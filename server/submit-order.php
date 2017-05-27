<?php
    // 待删，允许 CORS，方便本地测试
    header("Access-Control-Allow-Origin: *");
?>

<?php

// 客户端发送来的数据
$phone_number = $_POST['phone_number'];
$order_details = $_POST['order_details'];

?>

<?php
$servername = "p:localhost";
$username = "root";
$password = "";
$db_name = "qingong_db";
$table_name = "qingong_orders";

// 创建与数据库系统的连接
$mysqli = new mysqli($servername, $username, $password, $db_name);

// 设置默认的客户端字符集
$mysqli->set_charset("utf8");

// 将订单信息插入数据库
$sql = "INSERT INTO $table_name(phone_number,order_details) VALUES('$phone_number','$order_details')";

if ($mysqli->query($sql)) {
    echo "success";
    $mysqli->close();
    exit();
} else {
    echo "unknown_wrong";
    $mysqli->close();
    exit();
}

