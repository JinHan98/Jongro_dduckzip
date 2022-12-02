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

//예약 조회
function selectReservation($customer_id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT Order_id,Product_name,Order_datetime,Order_many,Price,Order_number FROM ORDERS O,PRODUCT P
    WHERE O.product_id=P.Product_id  and order_or_delivery=0
    and O.Customer_id=?";

    $st = $pdo->prepare($query);
    $st->execute([$customer_id]);

    $st = null;
    $pdo = null;
}


if($_SERVER["REQUEST_METHOD"]=="GET" ) {
    $data = [];
    
    try {

        if ( $_SERVER['REQUEST_URI']=="/orders.php/selectReservation"){
          // $customer_id= $_GET['customer_id'];

          // echo  $_GET['q'];
            //echo '아';
           // $res=selectReservation($customer_id);
            echo json_encode(array("reservationList"=>$res),JSON_UNESCAPED_UNICODE);
        }


 }
 
catch (Exception $e) {
    $errorLogs ="";
    return 1;
}


}



