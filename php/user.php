<?php
$res = (object)array();
header('Content-Type: json');
//mysqli_query($db, "set session character_set_connection=utf8;");
$req = json_decode(file_get_contents("php://input"));
//ini_set('default_charset', 'utf8mb4');
header('Content-Type: application/json');
header("Content-Type:text/html;charset=utf-8");
require './JWT.php';

const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";


function pdoSqlConnect()
{
    try {
        $DB_HOST = "jonro-db.cxmaycbc3ozq.ap-northeast-2.rds.amazonaws.com:3306";
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

function createJWT($userId) {
    $now_seconds = time();

    $payload = array(
        'iat' => $now_seconds,
        'exp' => $now_seconds + (60 * 60 * 24 * 365), // 유효기간 1년
        'userId' => $userId
    );

    return $jwt = JWT::encode($payload, JWT_SECRET_KEY);


}

function getJWT(){
    return $_SERVER["HTTP_X_ACCESS_TOKEN"];
}


function isValidJWT($jwt, $key): bool
{
    try {

        $decoded = JWT::decode($jwt, $key, array('HS256'));
    } catch (\Exception $e) {
        return false;
    }

    return is_array((array)$decoded);
}


function getDataByJWT($jwt)
{
    try {
        $decoded = JWT::decode($jwt, JWT_SECRET_KEY, array('HS256'));
    } catch (\Exception $e) {
        return "";
    }

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


function selectUserPassword($Phone_num)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT Password,Customer_id FROM CUSTOMERS where Phone_num =?";

    $st = $pdo->prepare($query);
    $st->execute([$Phone_num]);
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

      //  $ $_GET['q'];

        if ( $_SERVER['REQUEST_URI']=="/user.php/selectNames"){
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
            echo json_encode(array("result"=>$res),JSON_UNESCAPED_UNICODE);
        }

        if ( $_SERVER['REQUEST_URI']=="/user.php/login"){
            //body값 받는 코드

            $Phone_num = $_POST["Phone_num"];
            $Password = $_POST["Password"];

            //데이터 넣는 코드
            $userInfo=selectUserPassword($Phone_num);
            $userinfoResult = $userInfo[0];
            $userPassword = $userinfoResult['Password'];
            $userId = $userinfoResult['Customer_id'];

           /// echo $userInfo;


            $jwt = new JWT();

// 유저 정보를 가진 jwt 만들기
            $token = $jwt->hashing(array(
                'exp' => time() + (360 * 30), // 만료기간
                'iat' => time(), // 생성일
                'id' => $userId,
                'phone' => $Phone_num,
                'password' => $Password
            ));


            if ($userPassword==$Password){
                $res=["성공"];
                echo json_encode(array("result"=>$token),JSON_UNESCAPED_UNICODE);

            }
            else  {

                $res=["실패"];
                echo json_encode(array("result"=>$res),JSON_UNESCAPED_UNICODE);

            }



        }

        if ( $_SERVER['REQUEST_URI']=="/user.php/password"){
            //body값 받는 코드

            $Phone_num = $_POST["Phone_num"];


            //데이터 넣는 코드
            $userInfo=selectUserPassword($Phone_num);


            /// echo $userInfo;

            if ($userInfo!=null){
                $userinfoResult = $userInfo[0];
                $userPassword = $userinfoResult['Password'];
                $userId = $userinfoResult['Customer_id'];
                $res=["성공"];
                echo json_encode(array("result"=>$userPassword),JSON_UNESCAPED_UNICODE);

            }
            else  {

                $res=["실패"];
                echo json_encode(array("result"=>$res),JSON_UNESCAPED_UNICODE);

            }






        }

 }

 
catch (Exception $e) {
    $errorLogs ="";
    return 1;
}
}