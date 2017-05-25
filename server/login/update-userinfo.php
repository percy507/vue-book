<?php
    // 待删，允许 CORS，方便本地测试
    header("Access-Control-Allow-Origin: *");
?>

<?php

// 客户端发送来的数据
$user = $_POST['phone_number'];
$name = $_POST['name'];
$id_number = $_POST['id_number'];
$academy = $_POST['academy'];
$address = $_POST['address'];

if (!preg_match("/\d{11}/", $user)) {
    echo "wrong_data";
    exit();
};

if (!preg_match("/^[\x{4E00}-\x{9FCC}a-zA-Z]+$/u", $name)) {
    echo "wrong_data";
    exit();
};

if (!preg_match("/\d+/", $id_number)) {
    echo "wrong_data";
    exit();
};

$academyArr = ['理学院', '材料与纺织学院、丝绸学院', '服装学院', '信息学院', '机械与自动控制学院', '建筑工程学院', '生命科学学院', '经济管理学院', '艺术与设计学院', '法政学院', '外国语学院', '史量才新闻与传播学院', '马克思主义学院', '启新学院', '继续教育学院', '科技与艺术学院'];
if (!in_array($academy, $academyArr)) {
    echo "wrong_data";
    exit();
};

if (!preg_match("/^[\x{4E00}-\x{9FCC}\w]+$/u", $address)) {
    echo "wrong_data";
    exit();
};
?>

<?php
$servername = "p:localhost";
$username = "root";
$password = "";
$db_name = "qingong_db";
$table_name = "qingong_users";

// 创建与数据库系统的连接
$mysqli = new mysqli($servername, $username, $password, $db_name);

// 设置默认的客户端字符集
$mysqli->set_charset("utf8");

// 若用户存在，则更新密码
$sql = "UPDATE $table_name SET name = '$name',id_number = '$id_number',academy = '$academy',address = '$address' WHERE phone_number = '$user'";

if ($mysqli->query($sql)) {
    echo "update_userinfo_success";
    $mysqli->close();
    exit();
} else {
    echo "unknown_wrong";
    $mysqli->close();
    exit();
}