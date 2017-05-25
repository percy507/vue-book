<?php
    // 待删，允许 CORS，方便本地测试
    header("Access-Control-Allow-Origin: *");
?>

<?php
session_start();

$code = mt_rand(100000, 999999);
$_SESSION['auth_code'] = (string)$code;

$phone_number = $_POST['phone_number'];

// 验证数据的合法性
if (!preg_match("/\d{11}/", $phone_number)) {
    echo "wrong_data";
    exit();
};

if (isset($_POST['flag'])) {
    $flag = $_POST['flag'];
} else {
    echo 'flag_not_defined';
    exit();
}
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
$sql = "SELECT phone_number FROM $table_name WHERE phone_number = '$phone_number'";
$result = $mysqli->query($sql);

// 如果是忘记密码页面，则需要检测用户是否已存在
if ($flag === 'forget_password' && $result->num_rows === 0) {
    echo 'not_found';
    $mysqli->close();
    exit();
}

// 如果是注册页面，也需要检测用户是否已存在
if ($flag === 'signup' && $result->num_rows !== 0) {
    echo 'user_existed';
    exit();
}

?>

<?php

require_once './yunpian-sdk-php/YunpianAutoload.php';

// 发送单条短信
$smsOperator = new SmsOperator();
$data['mobile'] = $phone_number;
$data['text'] = "【伯牙书舍】您的验证码是".$code."。如非本人操作，请忽略本短信";
$result = $smsOperator->single_send($data);

if ($result->success) {
    echo 'success';
    exit();
} else {
    echo 'send_wrong';
    exit();
}
