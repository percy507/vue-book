<?php
/*
    $_POST["flag"] has four values
    'in-scan'
    'out-scan'
    'in-manual'
    'out-manual'
*/

$flag = $_POST["flag"];
$type = $_POST["kind"]; // 标记书的分类
$title = $_POST["title"];
$author = $_POST["author"];

// 根据 flag 来判断本次是扫码还是手动
$flagArr = explode("-", $flag, 2);
$flag = $flagArr[0]; // $flag == 'in' or 'out'
$way = $flagArr[1]; // $way == 'scan' or 'manual'


// 手动录入时，需要上传图片
if ($way == "manual" and $flag == "in") {
    $path = "./img/";
    if (!file_exists($path)) {
        mkdir($path);
    }

    $imageFile = $_FILES['imageFile']; // 获取上传的图片的数据
    
    // 若是 manual 操作，则需要对上传的文件进行处理
    // 将上传文件移动到指定目录下
    $tmp_name = $imageFile["tmp_name"];
    $name = $imageFile["name"];

    // 获得图片后缀，并使用书的编号作为文件名
    $suffix = pathinfo($name)['extension'];
    // 使用时间戳作为文件名
    $filename = time();

    $path = "./img/$filename.$suffix";

    move_uploaded_file($tmp_name, $path);

    $path = "./backend/img/$filename.$suffix";
    $imageSrc = $path;
} elseif ($way == "scan") {
    $imageSrc = $_POST["imageSrc"]; //获取图片的网络路径
}

$number = $_POST['number'];
?>

<?php
// 检测变量是否存在
if (!($flag && $way && $type && $title && $author && $number)) {
    echo "输入参数错误~";
    exit();
} elseif (!($way == "manual" and $flag == "out")) {
    if (!($imageSrc)) {
        echo "输入参数错误~";
        exit();
    }
}
?>

<?php
// 连接数据库
$servername = "p:localhost";
$username = "root";
$password = "";
$db_name = "qingong_db";
$table_name = "qingong_books";

// 创建与数据库系统的连接
$mysqli = new mysqli($servername, $username, $password, $db_name);

// 设置默认的客户端字符集
$mysqli->set_charset("utf8");

// 检测数据库中是否存在指定书籍（使用书名和作者名进行检测书籍的唯一性）
$sql = "SELECT * FROM $table_name WHERE book_title='$title' AND book_author='$author'";
$result = $mysqli->query($sql);
if ($result->num_rows == 0) {
    if ($flag == "out") {
        echo "数据库中还没有这本书呢，快去录入吧~";
        $mysqli->close();
        exit();
    } else {
        $isBookExist = false;
    }
} else {
    $isBookExist = true;

    if ($flag == "out") {
        // 若书籍存在，获取其剩余数量，方便录出书籍时使用
        $sql = "SELECT rest_number FROM $table_name WHERE book_title='$title' AND book_author='$author'";
        $result = $mysqli->query($sql);
        $row = $result->fetch_row();
        $rest_number = $row[0];
    }
}


// 处理 $way='scan' 的逻辑
if ($way == 'scan') {
    if ($flag == 'in') {
        if ($isBookExist) {
            // 若书籍存在，那么扫码录入仅更新 rest_number
            $sql = "UPDATE $table_name SET rest_number=rest_number+$number WHERE book_title='$title' AND book_author='$author'";
            
            if ($mysqli->query($sql)) {
                echo "录入数据成功~";
                $mysqli->close();
                exit();
            }
        } else {
            // 若书籍不存在，那么插入书籍的所有信息
            $needed_prop = "book_title,book_author,book_type,book_cover,rest_number";
            $sql = "INSERT INTO $table_name($needed_prop) VALUES('$title','$author','$type','$imageSrc',$number)";

            if ($mysqli->query($sql)) {
                echo "录入数据成功~";
                $mysqli->close();
                exit();
            }
        }
    } elseif ($flag == 'out') {
        if ($isBookExist) {
            if ($number < $rest_number) {
                // 若录出书籍小于剩余书籍，则正常录出
                $sql = "UPDATE $table_name SET rest_number=rest_number-$number WHERE book_title='$title' AND book_author='$author'";
            } elseif ($number == $rest_number) {
                // 若录处书籍正好等于剩余书籍，则从数据库中删除该书籍
                $sql = "DELETE FROM $table_name WHERE book_title='$title' AND book_author='$author'";
            } else {
                // 这种情况下是录出书籍大于剩余书籍，报错
                echo "录出参数错误，仓库没有那么多书啦~";
                $mysqli->close();
                exit();
            }

            if ($mysqli->query($sql)) {
                echo "录出数据成功~";
                $mysqli->close();
                exit();
            }
        }
    }
}

// 处理 $way='manual' 的逻辑
if ($way == 'manual') {
    if ($flag == 'in') {
        if ($isBookExist) {
            // 若书籍存在，那么手动录入将更新书籍的全部信息
            $updated_prop = "book_title='$title',book_author='$author',book_type='$type',book_cover='$imageSrc',rest_number=rest_number+$number";
            $sql = "UPDATE $table_name SET $updated_prop WHERE book_title='$title' AND book_author='$author'";
            
            if ($mysqli->query($sql)) {
                echo "录入数据成功~";
                $mysqli->close();
                exit();
            }
        } else {
            // 若书籍不存在，那么插入书籍的所有信息
            $needed_prop = "book_title,book_author,book_type,book_cover,rest_number";
            $sql = "INSERT INTO $table_name($needed_prop) VALUES('$title','$author','$type','$imageSrc',$number)";

            if ($mysqli->query($sql)) {
                echo "录入数据成功~";
                $mysqli->close();
                exit();
            }
        }
    } elseif ($flag == 'out') {
        if ($isBookExist) {
            if ($number < $rest_number) {
                // 若录出书籍小于剩余书籍，则正常录出
                $sql = "UPDATE $table_name SET rest_number=rest_number-$number WHERE book_title='$title' AND book_author='$author'";
            } elseif ($number == $rest_number) {
                // 若录处书籍正好等于剩余书籍
                // 删除上传的书籍封面图片
                $sql = "SELECT book_cover FROM $table_name WHERE book_title='$title' AND book_author='$author'";
                $result = $mysqli->query($sql);
                $row = $result->fetch_row();
                $imgPath = $row[0];
                if (file_exists($imgPath)) {
                    unlink($imgPath);
                }

                // 从数据库中删除该书籍
                $sql = "DELETE FROM $table_name WHERE book_title='$title' AND book_author='$author'";
            } else {
                // 这种情况下是录出书籍大于剩余书籍，报错
                echo "录出参数错误，仓库没有那么多书啦~";
                $mysqli->close();
                exit();
            }

            if ($mysqli->query($sql)) {
                echo "录出数据成功~";
                $mysqli->close();
                exit();
            }
        }
    }
}
