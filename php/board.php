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

// 게시판 (중계플랫폼) 작성
function insertBoard($StoreName, $Food, $Phone, $Address)
{

    $pdo = pdoSqlConnect();
    $query = "INSERT INTO BOARD (StoreName, Food, Phone, Address,Customer_id )
                VALUES (?,?,?,?,1)";
    $st = $pdo->prepare($query);
    $st->execute([$StoreName, $Food, $Phone, $Address]);
    $st = null;
    $pdo = null;
}

//배송 조회
function selectBoard()
{
    $pdo = pdoSqlConnect();
    $query = " select StoreName, Food, Phone, Address from BOARD";

    $st = $pdo->prepare($query);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $result;
}

//관리자 예약 조회 0이 예약임
function selectManagerReservation()
{
    $pdo = pdoSqlConnect();
    $query = "
SELECT Order_id,Product_name,Order_datetime,Order_many,Price,Order_number FROM ORDERS O,PRODUCT P,CUSTOMERS C
WHERE O.product_id=P.Product_id and C.Customer_id=O.customer_id and order_or_delivery=0";
    $st = $pdo->prepare($query);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $result;
}

//관리자 배송 조회
function selectManagerDelivery()
{
    $pdo = pdoSqlConnect();
    $query = "
SELECT Order_id,Product_name,Order_datetime,Order_many,Price,Order_number FROM ORDERS O,PRODUCT P,CUSTOMERS C
WHERE O.product_id=P.Product_id and C.Customer_id=O.customer_id and order_or_delivery=1";
    $st = $pdo->prepare($query);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $result;
}


if($_SERVER["REQUEST_METHOD"]=="GET" ) {
    try {
        //예약 조회
        if ($_SERVER['REQUEST_URI'] == "/board.php/selectBoard") {

            $res = selectBoard();
            echo json_encode(array("boardList" => $res), JSON_UNESCAPED_UNICODE);
        }


    } catch (Exception $e) {
        $errorLogs = "";
        return 1;
    }
}




    if($_SERVER["REQUEST_METHOD"]=="POST" ) {

     try {
         // board 작성
         $res=["성공"];
         if ( $_SERVER['REQUEST_URI']=="/board.php/insertBoard"){
             //body값 받는 코드
             $StoreName = $_POST["StoreName"];
             $Food = $_POST["Food"];
             $Phone = $_POST["Phone"];
             $Address = $_POST["Address"];
             //데이터 넣는 코드
             insertBoard($StoreName,$Food,$Phone,$Address);

             //응답 코드
             echo json_encode(array("result"=>$res),JSON_UNESCAPED_UNICODE);
         }

     }

      catch (Exception $e) {
          $errorLogs ="";
          return 1;
      }

 


}



