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

//예약 조회 0이 예약임
function selectReservation()
{
    $pdo = pdoSqlConnect();
    $query = "
SELECT Order_id,Product_name,reservationTime,Order_many,Price,Order_number,Order_price,O.status FROM ORDERS O,PRODUCT P,CUSTOMERS C
WHERE O.product_id=P.Product_id and C.Customer_id=O.customer_id and order_or_delivery=0
and O.customer_id=1";
    $st = $pdo->prepare($query);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $result;
}

//예약 주문하기
function insertReservation($customer_id,$product_id,$Order_number,$Order_many,$Order_datetime,$order_or_delivery,$reservationTime,$Order_price)
{
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO ORDERS (customer_id,product_id, Order_number, Order_many, Order_datetime,order_or_delivery,reservationTime,Order_price )
                VALUES (?,?,?,?,?,?,?,?)";
    $st = $pdo->prepare($query);
    $st->execute([$customer_id,$product_id,$Order_number,$Order_many,$Order_datetime,$order_or_delivery,$reservationTime,$Order_price]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $result;
}


//배달 주문하기
function insertDelivery($customer_id,$product_id,$Order_number,$Order_many,$Order_datetime,$order_or_delivery,$address, $Order_price)
{
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO ORDERS (customer_id,product_id, Order_number, Order_many, Order_datetime,order_or_delivery,address,Order_price )
                VALUES (?,?,?,?,?,?,?,?)";
    $st = $pdo->prepare($query);
    $st->execute([$customer_id,$product_id,$Order_number,$Order_many,$Order_datetime,$order_or_delivery,$address,$Order_price]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $result;
}


//배송 조회
function selectDelivery()
{
    $pdo = pdoSqlConnect();
    $query = "
SELECT Order_id,Product_name,Order_datetime,Order_many,Price,Order_number,address ,O.status , Order_price FROM ORDERS O,PRODUCT P,CUSTOMERS C
WHERE O.product_id=P.Product_id and C.Customer_id=O.customer_id and order_or_delivery=1
and O.customer_id=1";
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
SELECT Order_id,Product_name,Order_datetime,Order_many,Price,Order_number, O.status,O.address ,Order_price FROM ORDERS O,PRODUCT P,CUSTOMERS C
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
SELECT Order_id,Product_name,Order_datetime,Order_many,Price,Order_number, O.address, O.status ,Order_price FROM ORDERS O,PRODUCT P,CUSTOMERS C
WHERE O.product_id=P.Product_id and C.Customer_id=O.customer_id and order_or_delivery=1";
    $st = $pdo->prepare($query);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $result;
}

//관리자 예약, 배송 취소
function updateManagerDeliveryStatus($orderId)
{
    $pdo = pdoSqlConnect();
    $query = "UPDATE ORDERS SET status = 'F' WHERE Order_id=?";
    $st = $pdo->prepare($query);
    $st->execute([$orderId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $result;
}



if($_SERVER["REQUEST_METHOD"]=="GET" ) {
    $data = [];
    
    try {
        //예약 조회
        if ( $_SERVER['REQUEST_URI']=="/orders.php/selectReservation"){

            $res=selectReservation();
            echo json_encode(array("reservationList"=>$res),JSON_UNESCAPED_UNICODE);
        }

        //배송 조회
        if ( $_SERVER['REQUEST_URI']=="/orders.php/selectDelivery"){

            $res=selectDelivery();
            echo json_encode(array("deliveryList"=>$res),JSON_UNESCAPED_UNICODE);
        }

        //관리자 예약 조회
        if ( $_SERVER['REQUEST_URI']=="/orders.php/selectManagerReservation"){

            $res=selectManagerReservation();
            echo json_encode(array("reservationList"=>$res),JSON_UNESCAPED_UNICODE);
        }


        //관리자 배송 조회
        if ( $_SERVER['REQUEST_URI']=="/orders.php/selectManagerDelivery"){

            $res=selectManagerDelivery();
            echo json_encode(array("deliveryList"=>$res),JSON_UNESCAPED_UNICODE);
        }

        if (  strpos($_SERVER['REQUEST_URI'],"/orders.php/updateManagerDeliveryStatus")!==false){
            $res=["성공"];
            $orderId = $_GET['orderId'];
            updateManagerDeliveryStatus($orderId);
            echo json_encode(array("result"=>$res),JSON_UNESCAPED_UNICODE);
        }


 }


catch (Exception $e) {
    $errorLogs ="";
    return 1;
}


}

if($_SERVER["REQUEST_METHOD"]=="POST" ) {

    try {

        $res=["성공"];
        if ( $_SERVER['REQUEST_URI']=="/orders.php/insertReservation"){
            //body값 받는 코드

            $customer_id = $_POST["customer_id"];
            $product_id = $_POST["product_id"];
            $Order_number = $_POST["Order_number"];
            $Order_many = $_POST["Order_many"];
            $Order_datetime = $_POST["Order_datetime"];
            $reservationTime= $_POST["reservationTime"];
            $Order_price= $_POST["Order_price"];

            //데이터 넣는 코드
            insertReservation($customer_id,$product_id,$Order_number,$Order_many,$Order_datetime,0,$reservationTime,$Order_price);


            //응답 코드
            echo json_encode(array("result"=>$res),JSON_UNESCAPED_UNICODE);
        }

            if ( $_SERVER['REQUEST_URI']=="/orders.php/insertDelivery"){
            //body값 받는 코드

            $customer_id = $_POST["customer_id"];
            $product_id = $_POST["product_id"];
            $Order_number = $_POST["Order_number"];
            $Order_many = $_POST["Order_many"];
            $Order_datetime = $_POST["Order_datetime"];
            $address= $_POST["address"];
            $Order_price= $_POST["Order_price"];

            //데이터 넣는 코드
            insertDelivery($customer_id,$product_id,$Order_number,$Order_many,$Order_datetime,1,$address,$Order_price);

            //응답 코드
            echo json_encode(array("result"=>$res),JSON_UNESCAPED_UNICODE);
        }

    }
    catch (Exception $e) {
        $errorLogs ="";
        return 1;
    }


}