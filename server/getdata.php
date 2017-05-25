<?php
    // 待删，允许 CORS，方便测试
    header("Access-Control-Allow-Origin: *");
?>

<?php
// 接收客户端发送过来的请求数据

$type = $_GET['type'];
$data_num = $_GET['data_num'];
$request_count = $_GET['request_count'];
$user_state = $_GET['user_state'];

if ($type === 'search') {
    $keyword = $_GET['keyword'];

    // 关键字只允许有中文、字母、数字以及空格
    if (!preg_match("/^[\x{4E00}-\x{9FCC}\w ]+$/u", $keyword)) {
        echo "wrong_data";
        exit();
    };
}

// 如果用户登录成功，则取得用户所在的学院，方便按学院进行推荐书籍
if ($user_state === 'login_success') {
    $academy = $_GET['academy'];
}

// 以下三个查询变量为必须值
if (!($type and $data_num and $request_count and $user_state)) {
    exit();
}

?>

<?php
    $offset = ((int)$request_count - 1) * (int)$data_num;
?>

<?php
$servername = "p:localhost";
$username = "root";
$password = "";
$db_name = "qingong_db";
$table_name = "qingong_books";

// 创建与数据库系统的连接
$mysqli = new mysqli($servername, $username, $password, $db_name);

// 设置默认的客户端字符集
$mysqli->set_charset("utf8");

// 读取数据
$needed_prop = "book_title,book_author,book_cover,rest_number,book_type";
if ($type === 'home') {
    if ($user_state === 'login_success' and $academy) {
        $sql = "SELECT $needed_prop FROM $table_name ORDER BY book_type <> '$academy' LIMIT $data_num OFFSET $offset";
    } else {
        $sql = "SELECT $needed_prop FROM $table_name LIMIT $data_num OFFSET $offset";
    }
} elseif ($type === 'search') {
    if ($user_state === 'login_success' and $academy) {
        $sql = "SELECT $needed_prop FROM $table_name WHERE book_title LIKE '%$keyword%' OR book_author LIKE '%$keyword%' OR book_tags LIKE '%$keyword%' ORDER BY book_type <> '$academy' LIMIT $data_num OFFSET $offset";
    } else {
        $sql = "SELECT $needed_prop FROM $table_name WHERE book_title LIKE '%$keyword%' OR book_author LIKE '%$keyword%' OR book_tags LIKE '%$keyword%' LIMIT $data_num OFFSET $offset";
    }
} else {
    echo 'unknown error';
    exit();
}

$result = $mysqli->query($sql);

// 待删，方便前端显示加载效果，设定 1 秒的延迟
sleep(1);

if ($result->num_rows > 0) {
    // $allData = $result->fetch_all();
    $allData = [];
    while ($row = $result->fetch_row()) {
        array_push($allData, $row);
    }
    echo json_encode($allData, 256);
} else {
    echo "nothing";
}

// 断开与数据库的连接
$mysqli->close();


