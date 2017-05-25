// 检测 scanner 是否已经在运行
let isScanning = false;

// 开始扫码
function startScan() {
    if (isScanning) {
        // 去掉之前的 scanner 监听事件
        Quagga.offDetected(searchISBN);
        Quagga.stop();
    }

    // 检测摄像头，并获取摄像头的 ID 值
    let cameraArr = [];

    if (navigator.mediaDevices.enumerateDevices) {
        navigator.mediaDevices.enumerateDevices().then(function(devices) {
            devices.forEach(function(device) {
                if (device.kind == 'videoinput') {
                    cameraArr.push(device.deviceId);
                }
            });

            initscan(cameraArr[cameraArr.length - 1]);
        }).catch(function(err) {
            alert(err.name + ": " + err.message);
        });
    } else {
        alert('你的浏览器太旧了，赶快换成最新的 Google 浏览器吧 ~');
        return;
    }
}


/*  
 *  因为服务器返回的数据是全局的，
 *  所以必须将 JSONP 回调函数定义为全局函数
 */
let responseHandler;

var loading = document.querySelector('.loading');


// 扫条形码
function initscan(cameraID) {
    Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            constraints: {
                width: 1280,
                height: 720,
                facingMode: "environment",
                deviceId: cameraID
            },
            target: document.querySelector('#scanner')
        },
        frequency: 5,
        decoder: {
            readers: ["ean_reader"]
        }
    }, function(err) {
        if (err) {
            alert(err);
            return;
        }
        console.log("Initialization finished. Ready to start");
        Quagga.start();
        isScanning = true;
        Quagga.onDetected(searchISBN);
    });
}


// 利用 JSONP 从豆瓣跨域获取指定 ISBN 码的书籍信息
function searchISBN(data) {
    let code = data.codeResult.code;
    let codeHolder = document.getElementById('code-holder');

    codeHolder.innerHTML = '<span>ISBN 码：</span>' + code;
    Quagga.stop();

    let bookInfo = document.getElementById('book-info');
    let loadMessage = bookInfo.firstElementChild;
    loadMessage.classList.add('show-message');

    loading.classList.add('show-loading');

    // 通过 JSONP 跨域取得数据，并进行处理
    let url = 'https://api.douban.com/v2/book/isbn/:' + code;
    getJSONP(url).then(function(result) {
        loading.classList.remove('show-loading');

        useData(result);
    }).catch(function() {
        loading.classList.remove('show-loading');
        bookInfo.innerHTML = '<p class="load-message show-message">很抱歉，在豆瓣 API 中没有找到相关书籍，你可以选择重试或手动录入书籍~</p>';
    });
}

// 录入或录出书籍
function useData(json) {
    let title = json.title;
    let author = json.author.join('/');
    let imageSrc = json.images.large;
    let tags = '';
    let bookInfo = document.getElementById('book-info');

    json.tags.forEach(function(item) {
        tags += item.name + '|';
    });
    tags = tags.slice(0, -1);

    /*
     *  因为豆瓣返回的某些书籍的数据有时会不完整
     *  所以在这里进行一些简单的检测和处理
     */
    if (imageSrc) {
        imagSrc = json.image;
    }
    if (!title || !author || !imageSrc || imageSrc.match(/book-default/g)) {
        bookInfo.innerHTML = '<p class="load-message show-message">很抱歉，在豆瓣 API 中<b>没有获取到书籍的完整信息<b>，请手动录入书籍~</p>';
        return;
    }

    // 若书籍信息完整，则直接显示于页面上
    bookInfo.innerHTML = `
        <h1>书籍信息</h1>
        <div class="book-title"><span>书名：</span>${title}</div>
        <div class="book-author"><span>作者：</span>${author}</div>
        <div class="book-image"><img src="${imageSrc}" /></div>
        <div class="add-to-db">
            <label for="add-number">数量：</label><input id="add-number" width="100px" type="text" value="1"/>
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
        <div class="submit"><button id="submit-in" class="submit-data">录入</button><button id="submit-out" class="submit-data">录出</button></div>`;

    let dataObj = {
        title: title,
        author: author,
        imageSrc: imageSrc,
        tags: tags
    };

    // 提交数据到后台
    let submitIn = document.getElementById('submit-in');
    let submitOut = document.getElementById('submit-out');

    submitIn.onclick = function() {
        loading.classList.add('show-loading');
        submitIn.classList.add('submit-close');

        sendData('in-scan', dataObj).then(function(result) {
            alert(result.trim());
            loading.classList.remove('show-loading');
            submitIn.classList.remove('submit-close');
        }).catch(function() {
            loading.classList.remove('show-loading');
            submitIn.classList.remove('submit-close');
            alert('录入数据失败~');
        });
    };

    submitOut.onclick = function() {
        loading.classList.add('show-loading');
        submitOut.classList.add('submit-close');

        sendData('out-scan', dataObj).then(function(result) {
            alert(result.trim());
            loading.classList.remove('show-loading');
            submitOut.classList.remove('submit-close');
        }).catch(function() {
            loading.classList.remove('show-loading');
            submitOut.classList.remove('submit-close');
            alert('录出数据失败~');
        });
    };

    // 利用 Ajax 向服务器提交数据
    function sendData(flag, dataObj) {
        return new Promise(function(resolve, reject) {
            let url = "./operate.php";
            let request = new XMLHttpRequest();

            request.onload = function() {
                resolve(this.responseText);
            };

            request.onerror = reject;

            let bookData = new FormData();

            let number = document.getElementById('add-number').value;

            if (!number.match(/^[1-9][0-9]*$/)) {
                alert('请输入有效的数量 ~');

                let submitIn = document.getElementById('submit-in');
                let submitOut = document.getElementById('submit-out');
                loading.classList.remove('show-loading');
                submitIn.classList.remove('submit-close');
                submitOut.classList.remove('submit-close');
                return;
            }

            let title = dataObj.title;
            let author = dataObj.author;
            let imageSrc = dataObj.imageSrc;
            let kind = document.getElementById('select-kind').value;
            let tags = dataObj.tags;

            bookData.append('flag', flag.trim());
            bookData.append('kind', kind.trim());
            bookData.append('title', title.trim());
            bookData.append('author', author.trim());
            bookData.append('imageSrc', imageSrc.trim());
            bookData.append('number', number);
            bookData.append('tags', tags.trim());

            request.open("POST", url, true); // 初始化一个请求
            request.send(bookData); // 发送请求
        });
    }

}



// JSONP
function getJSONP(url) {
    return new Promise(function(resolve, reject) {
        if (url.indexOf('?') === -1) {
            url += '?callback=responseHandler';
        } else {
            url += '&callback=responseHandler';
        }

        // 使用 JSONP 实现跨域请求
        let script = document.createElement('script');
        script.setAttribute('src', url);
        document.body.appendChild(script);

        script.onerror = reject;
        // 处理回调函数
        responseHandler = function(json) {
            try {
                resolve(json);
            } finally {
                // 函数调用之后，移除对应的标签
                script.parentNode.removeChild(script);
            }
        };
    });
}