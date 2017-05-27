<?php
if (isset($_POST["user"]) and isset($_POST["password"])) {
    $user = $_POST["user"];
    $password = $_POST["password"];

    // 这里设置好登录后台的账号密码
    $rel_name = "hello";
    $rel_password = "world";

    // 判断账号密码是否正确
    $isRight = ($user == $rel_name and $password == $rel_password);

    // 如果正确，返回更新公告页面
    if ($isRight) {
        echo '<h1 style="text-align:center;font-size: 1.8em;margin: 5%;color: #FFF;">更新公告</h1><form  action="./message.php" method="post" style="position:relative;box-sizing: border-box;width: 100%;padding: 0 10px;"><textarea style="box-sizing: border-box;display: block;width: 100%;height: 500px;border: none;padding: 10px;resize: horizontal;font-size: 14px;color: #333;line-height: 1.6;" placeholder="请输入新的公告信息，注意排版 ~"></textarea><div class="update" style="box-sizing:border-box;position:absolute;bottom:-80px;left:0;right:0;z-index:9999;width:100%;height:40px;line-height:40px;font-size:16px;font-weight:bold;text-align:center;background:#51c1f0;color:#fbfbfb;margin-bottom:20px;" onclick="update()">确认更新</div></form>';
    } else {
        echo "wrong";
    }
} elseif (isset($_POST['textarea'])) {
    $text = $_POST['textarea'];

    // 验证数据的合法性
    if (preg_match("/(select)|(delete)|(create)|(update)|(like)|(drop)/i", $text)) {
        echo "出现了非法关键词，请重新输入 ~";
        exit();
    };

    // 连接数据库
    $servername = "p:localhost";
    $username = "root";
    $password = "";
    $db_name = "qingong_db";
    $table_name = "qingong_message";

    // 创建与数据库系统的连接
    $mysqli = new mysqli($servername, $username, $password, $db_name);

    // 设置默认的客户端字符集
    $mysqli->set_charset("utf8");

    $sql = "INSERT INTO $table_name(message) VALUES('$text')";

    if ($mysqli->query($sql)) {
        echo "success";
        $mysqli->close();
        exit();
    } else {
        echo "未知错误 ~";
        $mysqli->close();
        exit();
    }
} else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>公告更新</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <div class="main" style="position:relative">
        <div class="container">
            <form id="form" onsubmit="return false">
                <h1>公告更新</h1>
                <div class="form-item">
                    <label for="user"><span>账号</span></label>
                    <input id="user" type="text" name="user" autofocus>
                </div>
                <div class="form-item">
                    <label for="password"><span>密码</span></label>
                    <input id="password" type="password" name="password">
                </div>
                <div class="form-item">
                    <input id="login" type="submit" onclick="loginFunc()" value="登录">
                </div>
            </form>
        </div>
    </div>
    <div class="loading" v-show="show">
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            if (!((/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i).test(navigator.userAgent))) {
                document.documentElement.innerHTML = "<p>请使用手机微信打开此页面哦~</p>";
            }
        });
    </script>
    
    <script>
        function loginFunc(){
            let user = document.getElementById('user');
            let password = document.getElementById('password');
            let login = document.getElementById('login');
            let loading = document.querySelector('.loading');

            login.classList.add('submit-close');
            loading.classList.add('show-loading');

            sendData('./message.php',{
                user: user.value,
                password: password.value
            }).then(function(result) {
                if (result == 'wrong') {
                    login.classList.remove('submit-close');
                    loading.classList.remove('show-loading');

                    alert('用户名或密码错误~');
                } else {
                    loading.classList.remove('show-loading');
                    document.querySelector('.main').classList.add('message');
                    document.querySelector('.main').innerHTML = result;
                }
            }).catch(function() {
                alert('获取数据失败~');
            });
                
            
        }
        function update(){
            let textarea = document.querySelector('textarea');
            let submit = document.querySelector('.update');
            let loading = document.querySelector('.loading');

            submit.onclick = function(event) {
                submit.style.pointerEvents = 'none';
                loading.classList.add('show-loading');

                sendData('./message.php',{
                    textarea: textarea.value
                }).then(function(result) {
                    if (result == 'success') {
                        submit.style.pointerEvents = 'auto';
                        alert('公告已更新 ~');
                    } else {
                        submit.style.pointerEvents = 'auto';
                        alert(result);
                    }

                    loading.classList.remove('show-loading');
                }).catch(function() {
                    alert('获取数据失败~');
                });
                event.preventDefault();
            };
        }
        function sendData(url, dataObj) {
            return new Promise(function(resolve, reject) {
                let request = new XMLHttpRequest();

                request.onload = function() {
                    resolve(this.responseText.trim());
                };

                request.onerror = reject;

                let root = new FormData();
                
                for (let key of Object.keys(dataObj)) {
                    root.append(key, dataObj[key]);
                }

                request.open("POST", url, true); // 初始化一个请求
                request.send(root); // 发送请求
            });
        }
    </script>
</body>

</html>

<?php } ?>