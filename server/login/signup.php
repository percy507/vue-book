<?php
    // 待删，允许 CORS，方便本地测试
    header("Access-Control-Allow-Origin: *");
?>

<?php
// 通过 session 取得 get-auth-code.php 文件中生成的验证码
session_start();
$code = $_SESSION['auth_code'];

// 客户端发送来的数据
$user = $_POST['phone_number'];
$password = $_POST['password'];
$auth_code = $_POST['auth_code'];

// 服务端检测数据的正确性
if ($auth_code !== $code) {
    echo 'wrong_auth_code';
    exit();
}

if (!preg_match("/\d{11}/", $user)) {
    echo "wrong_data";
    exit();
};

if (!preg_match("/^\w{6,}$/", $password)) {
    echo "wrong_data";
    exit();
}

if (!preg_match("/\d{6}/", $auth_code)) {
    echo "wrong_data";
    exit();
}

$user_password = $password;
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

// 数据正确，检测 $user 的唯一性，即用户是否存在
$sql = "SELECT phone_number FROM $table_name WHERE phone_number = '$user'";
$result = $mysqli->query($sql);

if ($result->num_rows != 0) {
    echo 'phone_number_existed';
    $mysqli->close();
    exit();
}

// 若用户不存在，则插入数据库
$sql = "INSERT INTO $table_name(phone_number,password) VALUES('$user', '$user_password')";

if ($mysqli->query($sql)) {
    echo "signup_success";
    $mysqli->close();
    exit();
} else {
    echo "unknown_wrong";
    $mysqli->close();
    exit();
}

