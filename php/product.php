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

//추천 상품 조회
function selectMainPageProducts()
{
    $pdo = pdoSqlConnect();
    $query = "SELECT Product_name,Price,ImgUrl,Product_id FROM PRODUCT P limit 4";

    $st = $pdo->prepare($query);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();
    $st = null;
    $pdo = null;

    return $result;
}

//판매 상품 리스트
function selectProductList()
{
    $pdo = pdoSqlConnect();
    $query = "SELECT Product_name,Price,ImgUrl,Product_id FROM PRODUCT P";

    $st = $pdo->prepare($query);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();
    $st = null;
    $pdo = null;

    return $result;

}

//판매 상품 디테일
function selectProductDetail($productId)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT Product_name,Price,ImgUrl,ProductDetail FROM PRODUCT P where Product_id=?";

    $st = $pdo->prepare($query);
    $st->execute([$productId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $result = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $result;

}



if($_SERVER["REQUEST_METHOD"]=="GET" ) {
    $data = [];

    try {
        //메인 화면

        if ( $_SERVER['REQUEST_URI']=="/product.php/main"){
            $res=selectMainPageProducts();
            echo json_encode(array("products"=>$res),JSON_UNESCAPED_UNICODE);
        }

        //판매상품 조회
        if ( $_SERVER['REQUEST_URI']=="/product.php/product-list"){
            $res=selectProductList();
            echo json_encode(array("productList"=>$res),JSON_UNESCAPED_UNICODE);
        }

        //판매상품 디테일
        if (strpos($_SERVER['REQUEST_URI'],"/product.php/product-detail")!==false){


            $productId = $_GET['productId'];
            $res=selectProductDetail($productId);

            echo json_encode(array("productDetailList"=>$res),JSON_UNESCAPED_UNICODE);

        }



 }
catch (Exception $e) {
    $errorLogs ="";
    return 1;
}
}