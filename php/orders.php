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

//예약 조회
function selectReservation()
{
    $pdo = pdoSqlConnect();
    $query = "
SELECT Order_id,Product_name,Order_datetime,Order_many,Price,Order_number FROM ORDERS O,PRODUCT P,CUSTOMERS C
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

//배송 조회
function selectDelivery()
{
    $pdo = pdoSqlConnect();
    $query = "
SELECT Order_id,Product_name,Order_datetime,Order_many,Price,Order_number FROM ORDERS O,PRODUCT P,CUSTOMERS C
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


 }
 
catch (Exception $e) {
    $errorLogs ="";
    return 1;
}


}



