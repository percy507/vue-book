#
#   注意先建好下面的数据库表
#   要是建表时出现错误，注意检查是不是因为 MySQL 版本太低
#

-- 创建数据库
CREATE DATABASE qingong_db CHARACTER SET utf8 COLLATE utf8_general_ci;


-- 创建表 qingong_books，存储书籍信息
CREATE TABLE qingong_books(
    book_id     INT           NOT NULL AUTO_INCREMENT, # 并无实际用处，仅作为主键
    book_title  VARCHAR(100)  NOT NULL,                # 标题
    book_author VARCHAR(100)  NOT NULL,                # 作者
    book_type   VARCHAR(200)   NOT NULL,               # 书籍分类，这里按学院分
    book_cover  VARCHAR(1000) NOT NULL,                # 书籍封面图片链接地址
    rest_number INT           NOT NULL,                # 书籍库存量
    book_tags   VARCHAR(1000),                         # 书籍被标记的标签
    PRIMARY KEY(book_id)
)ENGINE=InnoDB AUTO_INCREMENT=20170001 DEFAULT CHARACTER SET utf8;


-- 创建表 qingong_users，存储用户信息
CREATE TABLE qingong_users(
    phone_number  VARCHAR(11)   NOT NULL,                     # 用户名，这里为手机号  
    password      VARCHAR(100)  NOT NULL,                     # 密码   
    name          VARCHAR(100)  NOT NULL DEFAULT "default",   # 用户姓名
    id_number     VARCHAR(50)   NOT NULL DEFAULT "default",   # 用户学号
    academy       VARCHAR(100)  NOT NULL DEFAULT "default",   # 用户所在学院
    address       VARCHAR(100)  NOT NULL DEFAULT "default",   # 用户寝室地址
    token         VARCHAR(100)  NOT NULL DEFAULT "default",   # 一个标识符，用来在用户自动登录时进行信息确定
    PRIMARY KEY(phone_number)
)ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

-- 在本地测试时，可以先用以下代码插入一个用户，方便测试
INSERT INTO qingong_users(phone_number, password, name, id_number, academy, address)
VALUES('17826856666', '123456', '张三丰', '666666', '信息学院', '武当山');


-- 创建表 qingong_orders，存储用户每次的订单信息
CREATE TABLE qingong_orders(
    order_id       INT           NOT NULL AUTO_INCREMENT,  # 并无实际用处，仅作为主键
    phone_number   VARCHAR(11)   NOT NULL,                 # 用户名，手机号 
    # 自动生成订单的日期
    order_time     TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    order_details  VARCHAR(1000) NOT NULL,                 # 订单的细节，这里以 JSON 字符串进行存储
    FOREIGN KEY (phone_number) REFERENCES qingong_users(phone_number),
    PRIMARY KEY(order_id)
)ENGINE=InnoDB AUTO_INCREMENT=20170001 DEFAULT CHARACTER SET utf8;


-- 创建表 qingong_message，存储每次管理员更新的帮助信息
CREATE TABLE qingong_message(
    message_id  INT           NOT NULL AUTO_INCREMENT,      # 并无实际用处，仅作为主键
    message     VARCHAR(5000) NOT NULL DEFAULT '暂无消息',   # 帮助信息
    PRIMARY KEY(message_id)
)ENGINE=InnoDB AUTO_INCREMENT=20170001 DEFAULT CHARACTER SET utf8;

