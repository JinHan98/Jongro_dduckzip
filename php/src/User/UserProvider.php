<?php

/*
유저 조회
 */
function retrieveUserInfo(): array
{
    $userInfo = selectUserInfo();

    if (count($userInfo) == 0) {
        return array('response' => EMPTY_USERINFO);
    }
    return array('response' => SUCCESS, 'result'=> $userInfo);
}
/*
유저 idx 로 조회
 */
function retrieveUserInfoById($userId): array
{
    $userInfo = selectUserInfoById($userId);

    if (count($userInfo) == 0) {
        return array('response' => EMPTY_USERINFO);
    }
    return array('response' => SUCCESS, 'result'=> $userInfo);
}

/*
유저 이메일로 조회
 */
function retrieveUserInfoByEmail($email): array
{
    $userInfo = selectUserInfoByEmail($email);

    if (count($userInfo) == 0) {
        return array('response' => EMPTY_USERINFO);
    }
    return array('response' => SUCCESS, 'result' => $userInfo);
}

/*
유저 성별로 조회
 */
function retrieveUserInfoByGender($gender): array
{
    $userInfo = selectUserInfoByGender($gender);

    if (count($userInfo) == 0) {
        return array('response' => EMPTY_USERINFO);
    }
    return array('response' => SUCCESS, 'result' => $userInfo);
}

function checkPassword($email, $password): array
{
    $checkPassword = selectUserPassword($email, $password);

//    echo $checkPassword."dsdsd";
    if (count($checkPassword) == 0) {
        return array('response' => EMPTY_USERINFO);
    }
    return array('response' => SUCCESS, 'result' => $checkPassword);
}