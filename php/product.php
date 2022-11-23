<?php
$res = (object)array();
header('Content-Type: json');
//mysqli_query($db, "set session character_set_connection=utf8;");
$req = json_decode(file_get_contents("php://input"));
//ini_set('default_charset', 'utf8mb4');
header('Content-Type: application/json');
header("Content-Type:text/html;charset=utf-8");
function pdoSqlConnect()
{
    try {
        $DB_HOST = "jonro.cxmaycbc3ozq.ap-northeast-2.rds.amazonaws.com:3306";
        $DB_NAME = "jonro";
        $DB_USER = "admin";
        $DB_PW = "hyun0202";
        $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PW);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("set names utf8");
        return $pdo;
    } catch (Exception $e) {

    }
}

function insertUserInfo()
{
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO CUSTOMERS (Name,  Password,Date, Phone_num)
                VALUES ('김규리','비밀번호', '날짜', '휴대폰번호')";

    $st = $pdo->prepare($query);
    $st->execute([]);

    $st = null;
    $pdo = null;
}

function selectUserName()
{
    $pdo = pdoSqlConnect();
    $query = "SELECT Name FROM CUSTOMERS";

    $st = $pdo->prepare($query);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();


    $st = null;
    $pdo = null;

    return $result;

}



if($_SERVER["REQUEST_METHOD"]=="GET" ) {
    $data = [];
    try {
        echo $_SERVER['REQUEST_URI'];
        if ( $_SERVER['REQUEST_URI']=="/user.php"){
            $res=selectUserName();
            echo json_encode(array("Name"=>$res),JSON_UNESCAPED_UNICODE);
        }


 }
catch (Exception $e) {
    $errorLogs ="";
    return 1;
}
}



