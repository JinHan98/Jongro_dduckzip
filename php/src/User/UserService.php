<?php
/*
유저 생성
 */
function createUserInfo($email, $password, $nickname): array
{
    // Service에서 Provider를 사용하는 예제 - 이메일 중복 확인
    $userInfo = retrieveUserInfoByEmail($email);
    if (isset($userInfo['result'])) {
        return array('response' => POST_USER_REDUNDANT_EMAIL);
    }

    // 비밀번호 암호화
    $hashedPassword = Encrypt($password, PASSWORD_SECRET_KEY, PASSWORD_SECRET_IV);
//    echo $hashedPassword;

    insertUserInfo($email, $hashedPassword, $nickname);
    return array('response' => SUCCESS);
}


/*
로그인 후 JWT 토큰 생성
 */
function postSignIn($email, $password): array
{
    // 이메일 가입 여부 확인.
    $userInfo = retrieveUserInfoByEmail($email);
    if (empty($userInfo['result'])) {
        return array('response' => EMPTY_USERINFO);
    }

    $userinfoResult = $userInfo['result'][0];
    $userId = $userinfoResult['userIdx'];

    $hashedPassword = Encrypt($password, PASSWORD_SECRET_KEY, PASSWORD_SECRET_IV);
//    echo $hashedPassword;

    $passwordCheck = checkPassword($email, $hashedPassword);

    if (empty($passwordCheck['result'])){
        return array('response' => GET_USERS_EMPTY_USER_PW);
    }

//    $jwt = array("jwt" => createJWT($email));

    $jwt = ["jwt" => createJWT($userId),
            "userId" => $userId];

    return array('response' => SUCCESS, 'result' => $jwt );
}

function editUser($nickname, $userId): array
{

    updateUserNickname($nickname, $userId);
    return array('response' => SUCCESS);

}