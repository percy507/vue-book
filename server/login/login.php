<?php
    // 待删，允许 CORS，方便本地测试
    header("Access-Control-Allow-Origin: *");
?>

<?php

if (isset($_POST['token'])) {
    $user = $_POST['phone_number'];
    $token = $_POST['token'];

    // 验证数据的合法性
    if (!preg_match("/\d{11}/", $user)) {
        echo "wrong_data";
        exit();
    };

    // 验证数据的合法性
    if (!preg_match("/\d+/", $token)) {
        echo "wrong_data";
        exit();
    };
} else {
    $user = $_POST['phone_number'];
    $password = $_POST['password'];

    // 验证数据的合法性
    if (!preg_match("/\d{11}/", $user)) {
        echo "wrong_data";
        exit();
    };

    if (!preg_match("/^\w{6,}$/", $password)) {
        echo "wrong_data";
        exit();
    }

    $user_password = $password;
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
$sql = "SELECT phone_number FROM $table_name WHERE phone_number = '$user'";
$result = $mysqli->query($sql);

if ($result->num_rows == 0) {
    echo 'not_found';
    $mysqli->close();
    exit();
}

if (isset($_POST['token'])) {
    // 若用户存在，则检测 token 是否一致
    $sql = "SELECT * FROM $table_name WHERE phone_number = '$user' AND token = '$token'";

    $result = $mysqli->query($sql);

    if ($result->num_rows == 0) {
        echo $sql;
        echo 'wrong_token';
        $mysqli->close();
        exit();
    }
} else {
    // 若用户存在，则检测密码是否正确
    $sql = "SELECT phone_number,password FROM $table_name WHERE phone_number = '$user' AND password = '$user_password'";

    $result = $mysqli->query($sql);

    if ($result->num_rows == 0) {
        echo 'wrong_password';
        $mysqli->close();
        exit();
    }
}

// 用户名、密码都正确，再检测用户的其它信息是否已完善
$sql = "SELECT name FROM $table_name WHERE phone_number = '$user'";

$result = $mysqli->query($sql);
$row = $result->fetch_row();

if ($row[0] === "default") {
    echo 'should_update_userinfo|';
    echo "$user";

    $mysqli->close();
    exit();
} else {
    echo 'login_success|';

    if (!isset($_POST['token'])) {
        // 获取时间戳，作为 token
        $token = (string)time();
        echo "$token|";

        // 将 token 存入数据库，方便下次自动登入时进行比较
        $sql = "UPDATE $table_name SET token = '$token' WHERE phone_number = '$user'";
        $mysqli->query($sql);
    }

    // 将用户数据返回给前端
    $sql = "SELECT phone_number,name,id_number,academy,address FROM $table_name WHERE phone_number = '$user'";

    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_row();
        echo json_encode($row, 256);
    }

    $mysqli->close();
    exit();
}
