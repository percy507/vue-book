<?php
if (!isset($_POST["user"]) || !isset($_POST["password"])) {
    echo '<meta name="viewport" content="width=device-width,initial-scale=1, user-scalable=no">';
    echo '<br/><h1 style="text-align:center">0.0</h1>';
    echo '<h3>Please login first~</h3>';
    exit;
}
?>

<?php
$user = $_POST["user"];
$password = $_POST["password"];
?>

<?php
// 这里设置好登录后台的账号密码
$rel_name = "hello";
$rel_password = "world";

// 判断账号密码是否正确
$isRight = ($user == $rel_name and $password == $rel_password);

// 利用 Ajax 预先判断账号密码是否正确
if (isset($_POST["check"])) {
    if ($isRight) {
        echo "right";
    } else {
        echo "wrong";
    }
} elseif ($isRight) {
// 在预检查通过后，返回正确的页面
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1, user-scalable=no">
    <title>录入||录出 书籍</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="./css/manage.css">
    <link rel="stylesheet" href="./css/scan.css">
    <link rel="stylesheet" href="./css/manual.css">
</head>

<body>
    <div class="loading" v-show="show">
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>

    <div class="which-way">
        <div class="choose choose-scan">扫 码</div>
        <div class="choose choose-manual">手 动</div>
    </div>

    <div class="hidden scan-add-book">
        <h1>请将摄像头对准条形码</h1>
        <div id="scanner"></div>
        <div id="code-holder"></div>
        <div id="book-info">
            <p class="load-message">请稍等片刻，正在从豆瓣查询相关书籍信息~</p>
        </div>
    </div>

    <div class="hidden manual-add-book">
        <h1>请填写下面信息</h1>
        <div id="book-form">
            <div class="form-item">
                <label for="book-title">书名：</label>
                <input id="book-title" type="text">
            </div>
            <div class="form-item">
                <label for="book-author">作者：</label>
                <input id="book-author" type="text">
            </div>
            <div class="form-item">
                <label>分类：</label>
                <select id="select-kind" name="kind">
                    <option value="理学院">理学院</option>
                    <option value="材料与纺织学院、丝绸学院">材料与纺织学院、丝绸学院</option>
                    <option value="服装学院">服装学院</option>
                    <option value="信息学院">信息学院</option>
                    <option value="机械与自动控制学院">机械与自动控制学院</option>
                    <option value="建筑工程学院">建筑工程学院</option>
                    <option value="生命科学学院">生命科学学院</option>
                    <option value="经济管理学院">经济管理学院</option>
                    <option value="艺术与设计学院">艺术与设计学院</option>
                    <option value="法政学院">法政学院</option>
                    <option value="外国语学院">外国语学院</option>
                    <option value="史量才新闻与传播学院">史量才新闻与传播学院</option>
                    <option value="马克思主义学院">马克思主义学院</option>
                    <option value="启新学院">启新学院</option>
                    <option value="继续教育学院">继续教育学院</option>
                    <option value="科技与艺术学院">科技与艺术学院</option>
                    <option value="其它">其它</option>
                </select>
            </div>
            <div class="form-item">
                <label for="book-tags">标签：</label>
                <input id="book-tags" type="text" placeholder="可选，标签之间用 '|' 隔开 ~">
            </div>
            <div class="form-item">
                <label for="book-number">数量：</label>
                <input id="book-number" type="text">
            </div>
            <div class="form-item">
                <label for="upload-img">上传封面图片</label>
                <input id="upload-img" type="file">
            </div>
            <div class="form-item">
                <button id="submit-in" class="submit-data">录入</button>
                <button id="submit-out" class="submit-data">录出</button>
            </div>
        </div>
        <div class="hint" style="text-align:center">
            <mark>如果是录出模式，则不需要上传图片</mark>
        </div>
    </div>
    <div class="hidden switch-way">
        <div id="scan">扫码</div>
        <div id="manual">手动</div>
    </div>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            if (!((/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i).test(navigator.userAgent))) {
                document.documentElement.innerHTML = "<p>请使用手机微信打开此页面哦~</p>";
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.11.6/quagga.min.js"></script>
    <script src="./js/scan.js"></script>
    <script src="./js/manual.js"></script>
    <script src="./js/manage.js"></script>
</body>

</html>

<?php } ?>
