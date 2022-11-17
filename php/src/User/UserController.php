<?php
require './src/User/UserProvider.php';
require './src/User/UserService.php';
require './src/User/UserPdo.php';

$res = (object)array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
try {
    addAccessLogs($accessLogs, $req);
    http_response_code(200);
    switch ($handler) {
//        case "test":
//            echo "Success Test";
//            break;

        /*
         * API No. 1
         * API Name : 유저 생성 (회원가입) API
         * [POST] /app/users
         */
        case "createUserInfo":
            $email = $req->email;
            $nickname = $req->nickname;
            $password = $req->password;

            // TODO: 형식적 / 의미적 Validation 더 추가해주세요!

            // 빈 값 체크
            if (empty($email)) {
                echo json_encode(POST_USERS_EMPTY_EMAIL, JSON_NUMERIC_CHECK);
                return;
            }
            // 정규표현식
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(POST_USERS_INVALID_EMAIL, JSON_NUMERIC_CHECK);
                return;
            }
            // 길이 체크
            if (strlen($email) > 30) {
                echo json_encode(POST_USERS_EMAIL_LENGTH, JSON_NUMERIC_CHECK);
                return;
            }

            $result = createUserInfo($email, $password, $nickname);
            break;

        /*
         * API No. 2
         * API Name : 유저 조회 API (+ 검색)
         * [GET] /app/users
         */
        case "retrieveUserInfo":

            $gender = $_GET["gender"]; // Query String

            if ($gender == null || $gender == "") {
                // 유저 전체 조회
                $result = retrieveUserInfo();
            } else {
                // 유저 검색 조회
                $result = retrieveUserInfoByGender($gender);
            }
            break;

        /*
         * API No. 3
         * API Name : 특정 유저 조회 API
         * [GET] /app/users/{userId}
         */
        case "retrieveUserInfoById":

            $userId = $vars["userId"]; // Path Variable

            if ($userId == null || $userId == "") {
                echo json_encode(GET_USERS_EMPTY_USER_ID, JSON_NUMERIC_CHECK);
                return;
            }

            $result = retrieveUserInfoById($userId);
            break;


        /*
     * API No. 4
     * API Name : 로그인 API
     * [POST] /app/tokens
     */
        case "login":
            $email = $req->email;
            $password = $req->password;

            //TO DO : 형식적 / 의미적 Validation 모두 추가해주세요!

            $result = postSignIn($email, $password);
            $result['jwt'] = $result . result;

            break;

        /*
         * API No. 5
         * API Name : 유저 수정 API
         * [PATCH] /app/users/{userIdx}
         */
        case "patchUsers":
            $nickname = $req->nickname;

            $jwt = getJWT();//사용자가 가지고 있는 토큰이 유효한지 확인하고
            $userId = $vars["userId"]; // Path Variable


            if ($jwt == null || $jwt == "") {
                echo json_encode(TOKEN_EMPTY, JSON_NUMERIC_CHECK);
                return;
            }

            if (!isValidJWT($jwt, JWT_SECRET_KEY)) {
                echo json_encode(TOKEN_VERIFICATION_FAILURE, JSON_NUMERIC_CHECK);
                return;
            }

            if (getIdByJWT($jwt) != $userId) {
                echo json_encode(TOKEN_VERIFICATION_USERID_FAILURE, JSON_NUMERIC_CHECK);
                return;
            }
            if ($nickname == null || $nickname == "") {
                echo json_encode(USER_NICKNAME_EMPTY, JSON_NUMERIC_CHECK);
                return;
            }

            $result = editUser($nickname, $userId);

    }

    // Provider, Service 에서 받은 결과 값을 json 형태로 return
    $res = $result['response'];

    if (isset($result['result'])) {
        $res['result'] = $result['result'];
    }

    echo json_encode($res, JSON_NUMERIC_CHECK);

} catch (Exception $e) {
    return getException($errorLogs, $e, $req);
}
