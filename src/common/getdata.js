/**
 * @description 利用 Ajax 获取数据
 * 
 * @param {string} url             地址
 * @param {string} [method='get']  方法
 * @param {object} queryObj        url查询对象
 * @returns  promise 对象
 */

/*
    注意：下面函数未针对 POST 方法进行优化
*/

const getData = function(url, method = 'get', queryObj) {

    // 解析 URL
    if (typeof method !== 'string') {
        queryObj = method;
        method = 'get';
    }
    if (queryObj && Object.prototype.toString.call(queryObj) == '[object Object]') {
        let keyArr = Object.keys(queryObj);
        let len = keyArr.length;
        let queryStr = '';
        for (let i = 0; i < len; i++) {
            queryStr += encodeURIComponent(keyArr[i]) + '=' + encodeURIComponent(queryObj[keyArr[i]]);
            if (i + 1 != len) {
                queryStr += '&';
            }
        }
        if (url.charAt(url.length - 1) != '?') {
            url += '?';
        }
        url += queryStr;
    }

    return new Promise(function(resolve, reject) {

        let request = new XMLHttpRequest();

        request.onload = function() {
            resolve(this.responseText);
        };

        request.onerror = reject;
        request.open(method, url);
        request.send();
    });
}

/* example
let url = 'http://blog.percymong.com/2017/04/14/';
getData(url).then(function(result) {
    console.log(result);
}).catch(function() {
    alert('获取数据失败~');
});
*/

export default getData;