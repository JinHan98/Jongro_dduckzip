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

//회원가입
function insertUserInfo($Name,$Password,$Phone_num)
{


    $pdo = pdoSqlConnect();
    $query = "INSERT INTO CUSTOMERS (Name,  Password, Phone_num)
                VALUES (?,?,?)";
    $st = $pdo->prepare($query);
    $st->execute([$Name,$Password,$Phone_num]);
    $st = null;
    $pdo = null;
}




function selectUserName()
{
    $pdo = pdoSqlConnect();
    $query = "SELECT Name,Password FROM CUSTOMERS";

    $st = $pdo->prepare($query);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();


    $st = null;
    $pdo = null;

    return $result;

}

//쿼리스트링 코드
//echo file_get_contents("php://input");
//  echo json_decode(file_get_contents("php://input"))->{"num1"};

// echo json_encode(array("name"=>$res),JSON_UNESCAPED_UNICODE);
 
if($_SERVER["REQUEST_METHOD"]=="GET" ) {
    $data = [];
    
    try {

        $ $_GET['q'];
        echo $_SERVER['REQUEST_URI'];
        if ( $_SERVER['REQUEST_URI']=="/user.php/selectName"){
            $res=selectUserName();
            echo json_encode(array("name"=>$res),JSON_UNESCAPED_UNICODE);
        }


 }

 
catch (Exception $e) {
    $errorLogs ="";
    return 1;
}
}
// 로그인 후 순위
 //post 메소드
if($_SERVER["REQUEST_METHOD"]=="POST" ) {

    
    try {
        //회원가입
        $res=["성공"];
        if ( $_SERVER['REQUEST_URI']=="/user.php"){
            //body값 받는 코드
            $Name = $_POST["Name"];
            $Phone_num = $_POST["Phone_num"];
            $Password = $_POST["Password"];

            //데이터 넣는 코드
            insertUserInfo($Name,$Password,$Phone_num);

            //응답 코드
            echo json_encode(array("name"=>$res),JSON_UNESCAPED_UNICODE);
        }

 }

 
catch (Exception $e) {
    $errorLogs ="";
    return 1;
}
}



