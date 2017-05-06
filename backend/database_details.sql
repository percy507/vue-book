-- 创建数据库
CREATE DATABASE qingong_db CHARACTER SET utf8 COLLATE utf8_general_ci;

-- 创建表 qingong_books
CREATE TABLE qingong_books(
    book_id     INT           NOT NULL AUTO_INCREMENT,
    book_title  VARCHAR(100)  NOT NULL,
    book_author VARCHAR(100)  NOT NULL,
    book_type   VARCHAR(50)   NOT NULL,
    book_cover  VARCHAR(1000) NOT NULL,   -- cover path
    rest_number INT           NOT NULL,
    PRIMARY KEY(book_id)
)ENGINE=InnoDB AUTO_INCREMENT=20170001 DEFAULT CHARACTER SET utf8;

-- 插入数据
INSERT INTO qingong_books(book_title,book_author,book_type,book_cover,rest_number)
VALUES('别在动感情','采薇','other_books','https://img1.doubanio.com/lpic/s28314128.jpg',22);