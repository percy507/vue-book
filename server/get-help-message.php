<?php
    // 待删，允许 CORS，方便本地测试
    header("Access-Control-Allow-Origin: *");
?>

<?php
$servername = "p:localhost";
$username = "root";
$password = "";
$db_name = "qingong_db";
$table_name = "qingong_message";

// 创建与数据库系统的连接
$mysqli = new mysqli($servername, $username, $password, $db_name);

// 设置默认的客户端字符集
$mysqli->set_charset("utf8");

// 将订单信息插入数据库
$sql = "SELECT message FROM $table_name ORDER BY message_id DESC LIMIT 1";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_row();

    echo json_encode($row, 256);
} else {
    echo "暂无消息";
}

// 断开与数据库的连接
$mysqli->close();