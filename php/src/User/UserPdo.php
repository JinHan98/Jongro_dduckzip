<?php


/*
유저 생성
 */
function insertUserInfo($email, $password, $nickname)
{
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO UserInfo (email, password, nickname)
                VALUES (?, ?, ?)";

    $st = $pdo->prepare($query);
    $st->execute([$email, $password, $nickname]);

    $st = null;
    $pdo = null;
}

/*
유저 리스트 조회
 */
function selectUserInfo()
{
    $pdo = pdoSqlConnect();
    $query = "select userIdx, nickname, email from UserInfo;";

    $st = $pdo->prepare($query);
    $st->execute([]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $result;
}


/*
유저 idx 로 조회
 */
function selectUserInfoById($userId)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT userIdx, email, nickname  FROM UserInfo WHERE userIdx = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$userId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $result[0];
}

/*
유저 닉네임으로 조회
 */
function selectUserInfoByNickname($nickname): array
{
    $pdo = pdoSqlConnect();
    $query = "SELECT id, email, nickname, password, phoneNumber, status FROM UserInfo WHERE nickname = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$nickname]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $result;
}

/*
유저 성별로 조회
 */
function selectUserInfoByGender($gender): array
{
    $pdo = pdoSqlConnect();
    $query = "SELECT userIdx, email, nickname, gender FROM UserInfo WHERE gender = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$gender]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $result;
}


function selectUserInfoByEmail($email): array
{
    $pdo = pdoSqlConnect();
    $query = "SELECT userIdx, email, nickname FROM UserInfo WHERE email = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$email]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $result;
}

function selectUserPassword($email, $hashedPassword): array
{
    $pdo = pdoSqlConnect();
    $query = "SELECT email, nickname FROM UserInfo WHERE email = ? and password = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$email, $hashedPassword]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $result;
}

/*
유저 닉네임 수정
 */
function updateUserNickname($nickname, $userIdx){
    $pdo = pdoSqlConnect();
    $query = "UPDATE UserInfo SET nickname = ? WHERE userIdx = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$nickname, $userIdx]);
    $st = null;
    $pdo = null;
}


// RETURN BOOLEAN
//    function isRedundantEmail($email){
//        $pdo = pdoSqlConnect();
//        $query = "SELECT EXISTS(SELECT * FROM UserInfo WHERE userIdx= ?) AS exist;";
//
//
//        $st = $pdo->prepare($query);
//        //    $st->execute([$param,$param]);
//        $st->execute([$email]);
//        $st->setFetchMode(PDO::FETCH_ASSOC);
//        $res = $st->fetchAll();
//
//        $st=null;$pdo = null;
//
//        return intval($res[0]["exist"]);
//
//    }