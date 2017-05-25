(function() {
    let bookTitle = document.getElementById('book-title');
    let bookAuthor = document.getElementById('book-author');
    let selectKind = document.getElementById('select-kind');
    let bookTags = document.getElementById('book-tags');
    let bookNumber = document.getElementById('book-number');
    let uploadImg = document.getElementById('upload-img');

    uploadImg.onchange = function() {
        uploadImg.previousElementSibling.innerHTML = '已选中 ' + uploadImg.files.length + ' 个文件';
    };

    // 提交数据到后台
    let submitIn = document.getElementById('submit-in');
    let submitOut = document.getElementById('submit-out');

    let loading = document.querySelector('.loading');

    submitIn.onclick = function() {
        let flag = 'in-manual';

        if (!detectData(flag)) {
            return;
        }

        loading.classList.add('show-loading');
        submitIn.classList.add('submit-close');

        sendData(flag).then(function(result) {
            alert(result.trim());
            loading.classList.remove('show-loading');
            submitIn.classList.remove('submit-close');
        }).catch(function() {
            alert('录入数据失败~');
        });
    };

    submitOut.onclick = function() {
        let flag = 'out-manual';

        if (!detectData(flag)) {
            return;
        }

        loading.classList.add('show-loading');
        submitOut.classList.add('submit-close');

        sendData(flag).then(function(result) {
            alert(result.trim());
            loading.classList.remove('show-loading');
            submitOut.classList.remove('submit-close');
        }).catch(function() {
            alert('录出数据失败~');
        });
    };

    // 验证数据
    function detectData(flag) {
        let isRight = true;

        if (!bookTitle.value) {
            alert('请输入书名~');
            isRight = false;
        } else if (!bookAuthor.value) {
            alert('请输入作者~');
            isRight = false;
        } else if (!bookNumber.value.match(/^[1-9][0-9]*$/)) {
            alert('请输入有效的数量~');
            isRight = false;
        }

        // 如果是录出模式，则不需要上传图片
        if (flag.match(/^in/) && isRight) {
            // 检测是否上传封面图片
            if (uploadImg.files.length != 1) {
                alert('请上传一张封面图片~');
                isRight = false;
            }

            // 客户端检测文件类型是否为图片
            if (!uploadImg.files[0].type.match(/image.*/)) {
                alert('请上传有效的图片类型~');
                isRight = false;
            }

            // 限制上传图片的大小（小于 200KB） 
            if (uploadImg.files[0].size > 200000) {
                alert('请上传一张小于 200KB 的图片~');
                isRight = false;
            }
        }

        return isRight;
    }

    // 利用 Ajax 向服务器提交数据
    function sendData(flag) {
        return new Promise(function(resolve, reject) {
            let url = "./operate.php";
            let request = new XMLHttpRequest();

            request.onload = function() {
                resolve(this.responseText);
            };

            request.onerror = reject;

            var bookData = new FormData();

            bookData.append('flag', flag);
            bookData.append('kind', selectKind.value.trim());
            bookData.append('title', bookTitle.value.trim());
            bookData.append('author', bookAuthor.value.trim());
            bookData.append('imageFile', uploadImg.files[0]);
            bookData.append('number', bookNumber.value);
            bookData.append('tags', bookTags.value.trim());

            request.open("POST", url, true); // 初始化一个请求
            request.send(bookData); // 发送请求
        });
    }
})();