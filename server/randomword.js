// 生成随机的指定数量的数据

let temp = "INSERT INTO qingong_books(book_title,book_author,book_type,book_cover,rest_number,book_tags) VALUES";
let time = 10000; // 定义生成数据的数量

let book_type = ['理学院', '材料与纺织学院、丝绸学院', '服装学院', '信息学院', '机械与自动控制学院', '建筑工程学院', '生命科学学院', '经济管理学院', '艺术与设计学院', '法政学院', '外国语学院', '史量才新闻与传播学院', '马克思主义学院', '启新学院', '继续教育学院', '科技与艺术学院', '其它'];

let letters = 'ABCDEFGHIGKLMNOPQRSTUVWXYZ01234567890123456789';
let letterArr = letters.split('');
let len = letterArr.length;

function randomWord(num) {
    let word = '';
    for (let k = 0; k < Math.floor(Math.random() * num + 5); k++) {
        word += letterArr[Math.floor(Math.random() * len)];
    }
    return word;
}

for (let i = 0; i < time; i++) {
    let data = `('${randomWord(20)}' , '${randomWord(10)}','${book_type[Math.floor(Math.random() * 17)]}','https://img1.doubanio.com/lpic/s2831${Math.floor(Math.random() * 8888 + 1000)}.jpg', ${Math.floor(Math.random() * 100 + 1)},'${randomWord(5)+"|"+randomWord(5)+"|"+randomWord(5)}'),`;
    temp += data;
    if (i + 1 == time) {
        temp = temp.slice(0, temp.length - 1);
        temp += ';';
    }
}