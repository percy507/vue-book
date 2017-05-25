/**
 * @description 利用 Ajax 发送数据
 * 
 * @param {string} url            地址
 * @param {object} dataObj        包含发送数据的对象
 * @returns  promise 对象
 */

const sendData = function(url, dataObj) {
    return new Promise(function(resolve, reject) {
        let request = new XMLHttpRequest();

        request.onload = function() {
            resolve(this.responseText.trim());
        };

        request.onerror = function() {
            reject(new Error(this.statusText));
        };

        let root = new FormData();

        for (let key of Object.keys(dataObj)) {
            root.append(key, dataObj[key]);
        }

        request.open("POST", url, true);
        request.send(root);
    });
}

export default sendData;