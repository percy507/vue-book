-- 创建数据库
CREATE DATABASE qingong_db CHARACTER SET utf8 COLLATE utf8_general_ci;

-- 创建表 qingong_books
CREATE TABLE qingong_books(
    book_id     INT           NOT NULL AUTO_INCREMENT,
    book_title  VARCHAR(100)  NOT NULL,
    book_author VARCHAR(100)  NOT NULL,
    book_type   VARCHAR(200)   NOT NULL,
    book_cover  VARCHAR(1000) NOT NULL,
    rest_number INT           NOT NULL,
    book_tags   VARCHAR(1000),
    PRIMARY KEY(book_id)
)ENGINE=InnoDB AUTO_INCREMENT=20170001 DEFAULT CHARACTER SET utf8;

-- 插入数据
INSERT INTO qingong_books(book_title,book_author,book_type,book_cover,rest_number,book_tags)
VALUES('别在动感情','采薇','other_books','https://img1.doubanio.com/lpic/s28314128.jpg',22);

SELECT * FROM qingong_books ORDER BY book_type <> '信息学院';

-- 创建表 qingong_users
CREATE TABLE qingong_users(
    phone_number  VARCHAR(11)   NOT NULL,
    password      VARCHAR(100)  NOT NULL,
    name          VARCHAR(100)  NOT NULL DEFAULT "default",
    id_number     VARCHAR(50)   NOT NULL DEFAULT "default",
    academy       VARCHAR(100)  NOT NULL DEFAULT "default",
    address       VARCHAR(100)  NOT NULL DEFAULT "default",
    token         VARCHAR(100)  NOT NULL DEFAULT "default",
    PRIMARY KEY(phone_number)
)ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

-- 插入数据
INSERT INTO qingong_users(phone_number,password)
VALUES('17826856666','123456');

-- 更新数据
UPDATE qingong_users
SET
name = '张三丰',
id_number = '2014329666666',
academy = '信息学院',
address = '生活二区6号北楼666寝室'
WHERE phone_number = '17826856666';



