<?php
use Firebase\JWT\JWT;

// JWT 생성
function createJWT($userId) {
    $now_seconds = time();

    // iat: 발급시간, exp: 유효기간, userIdx: 유저 식별자
    $payload = array(
        'iat' => $now_seconds,
        'exp' => $now_seconds + (60 * 60 * 24 * 365), // 유효기간 1년
        'userId' => $userId
    );

//    echo json_encode($payload);

    return $jwt = JWT::encode($payload, JWT_SECRET_KEY);

//    echo "encoded jwt: " . $jwt . "n";
//    $decoded = JWT::decode($jwt, $secretKey, array('HS256'))
//    print_r($decoded);
}

// JWT 반환
function getJWT(){
    return $_SERVER["HTTP_X_ACCESS_TOKEN"];
}

// JWT 유효성 검사
function isValidJWT($jwt, $key): bool
{
    try {
        // JWT::decode 내의 JWT Verify 로직을 통과하면 Payload를 반환한다.
        $decoded = JWT::decode($jwt, $key, array('HS256'));
    } catch (\Exception $e) {
        return false;
    }

    return is_array((array)$decoded);
}

// JWT Payload 반환
function getDataByJWT($jwt)
{
    try {
        $decoded = JWT::decode($jwt, JWT_SECRET_KEY, array('HS256'));
    } catch (\Exception $e) {
        return "";
    }

//    print_r($decoded);
    return $decoded;
}

function getIdByJWT($jwt){
    try{
        $decoded = JWT::decode($jwt, JWT_SECRET_KEY, array('HS256'));
    }catch(\Exception $e){
        return "";
    }

    return $decoded->userId;
}
