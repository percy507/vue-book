# Vue-book 2.0

## 说明

* **前端: Vue.js + Vuex + Webpack2**
* **后端: php + MySQL**

> 要是你对 PHP 和 MySQL 没啥基础，可以逛逛[**我的博客**](http://blog.percymong.com/archives/)，有几篇文章是用来介绍这些基础的。

本项目是一个简单的全栈项目，前端新手可以拿来练练手。

项目实现了一些简单的功能，后台可以对图书进行录入录出（扫码或手动），前台显示录入的图书，并且前台注册登录后可以将书的订单发给服务器，并存到服务器。具体请看下面的实现逻辑图。

![logic](https://github.com/percy507/vue-book/blob/master/_image/simple-logic.png)

我在自己的服务器上把这个项目搭建好了，但是，目前不便给出登录后台的链接，只给出前台的链接，本项目只针对移动端，所以最好在手机上查看链接 ^_^

## Demo && 演示

![二维码](https://github.com/percy507/vue-book/blob/master/_image/qr_code.png)

* [前台链接](http://www.percymong.com/book2)

* **前台登录测试账号：15566666666，密码：666666**

---

<img src="https://github.com/percy507/vue-book/blob/master/_image/1.png" width="200"> | | | | | | | <img src="https://github.com/percy507/vue-book/blob/master/_image/2.png" width="200"> | | | | | | | <img src="https://github.com/percy507/vue-book/blob/master/_image/3.png" width="200">

<img src="https://github.com/percy507/vue-book/blob/master/_image/4.png" width="200"> | | | | | | | <img src="https://github.com/percy507/vue-book/blob/master/_image/5.png" width="200"> | | | | | | | <img src="https://github.com/percy507/vue-book/blob/master/_image/6.png" width="200">

<img src="https://github.com/percy507/vue-book/blob/master/_image/7.png" width="200"> | | | | | | | <img src="https://github.com/percy507/vue-book/blob/master/_image/8.png" width="200"> | | | | | | | <img src="https://github.com/percy507/vue-book/blob/master/_image/9.png" width="200">

<img src="https://github.com/percy507/vue-book/blob/master/_image/10.png" width="200"> | | | | | | | <img src="https://github.com/percy507/vue-book/blob/master/_image/11.png" width="200">


## Build Setup

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build
```

> 我在本地测试用的服务器是 [WAMP Server](http://www.wampserver.com/en/)。

为了方便大家阅读源码，我列出了前后端数据交互时比较重要一些的接口，方便大家进行参考！[（点我查看）](additional.md)

## 项目目录说明

```bash
Vue-book directory
|
├── server                               # 存放服务端操作的文件夹
|  ├── backend               
|     ├── css                                # 存放后台样式文件
|        ├── login.css                       # 登录后台页面的样式
|        ├── manage.css                      # 后台操作页面的一部分样式
|        ├── manual.css                      # 后台手动操作的样式
|        └── scan.css                        # 后台扫码操作的样式
|     ├── js
|        ├── manage.js                       # 进入管理界面的效果脚本
|        ├── manual.js                       # 后台手动操作的脚本
|        └── scan.js                         # 后台扫码操作的脚本
|     ├── index.html                         # 后台登录页面
|     ├── manage.php                         # 登录后台成功后返回的管理页面
|     ├── message.php                        # 后台更改前台公告的脚本
|     └── operate.php                        # 定义后台操作与数据库交互的逻辑
|  ├── login
|     ├── yunpian-sdk-php                    # 存放云片网的 SDK（外包短信服务）
|     ├── forget-password.php                # 忘记密码时的后台脚本
|     ├── get-auth-code.php                  # 获取验证码时的后台脚本
|     ├── login.php                          # 前台登录时的后台验证脚本
|     ├── signup.php                         # 注册时的后台脚本
|     └── update-userinfo.php                # 完善或更新个人信息时的后台脚本
|  ├── database_details.sql                  # 数据库表的定义
|  ├── randomword.js                         # 生成指定数量随机数据的脚本（测试时可用） 
|  ├── get-help-message.php                  # 前端获取公告时的后端脚本
|  ├── getdata.php                           # 前端获取书籍时的后端脚本
|  └── submit-order.php                      # 前端提交书单（订单）的后端脚本
├── src                                  # 存放前端源码
|  ├── common
|     ├── error.png                          # 图片加载失败时默认显示的图片
|     ├── fullscreen.js                      # 全屏显示脚本
|     ├── getdata.js                         # Ajax GET 获取数据脚本
|     ├── loading.gif                        # 图片加载中时默认显示的图片
|     └── senddata.js                        # Ajax POST 发送数据脚本
|  ├── components                            # 盛放各种组件
|     ├── content                            
|        ├── book-card.vue                   # 书籍详细信息
|        ├── book-item.vue                   # 书籍简要信息
|        └── content.vue                     # 内容块
|     ├── menu
|        ├── book-list.vue                   # 我的书单
|        ├── help.vue                        # 帮助
|        ├── menu.vue                        # 菜单
|        └── setting.vue                     # 设置
|     ├── login-css                          # 定义前台登录界面的 css
|        ├── login-forget-password.css
|        ├── login-login.css
|        ├── login-normal.css
|        ├── login-signup.css
|        └── login-userinfo.css
|     ├── login.vue                          # 前台登录
|     ├── container.vue                      # 大包含块
|     ├── header.vue                         # 页面头
|     ├── loading.vue                        # 载入中
|     └── overlay.vue                        # 覆盖层（显示侧边栏时出现）
|  ├── router                              
|     └── routes.js                          # 路由（好吧，好像我没怎么用）
|  └── vuex
|     └── store.js                           # Vuex 状态管理
|  ├── app.vue
|  ├── main.js                               # 程序入口文件
├── additional.md                            # 前后数据交互接口简要说明文件
├── index.html
├── package.json                             # 程序的相关依赖
├── README.md
└── webpack.config.js                        # Webpack 配置相关信息
```

## 实现的功能

* 前台用户手机验证码注册、登录以及忘记密码
* 前台数据图片懒加载
* 前台向后台请求数据时有数量限定（比如一次返回 20 条数据）
* 搜索功能
* sessionStorage 实现我的书单功能（类似购物车）
* 使用时间戳以及 cookie 实现一小时内自动登录
* 增加全屏显示菜单（因为项目在微信上用，所以全屏显示的代码先被注释掉了）
* 扫条形码录入录出书籍（书籍信息基于豆瓣书籍 API）
* 手动录入录出书籍
* 后台登录更改公告信息

## 未解决问题

* 切换内容页面时，自动滚动到内容最顶部（content.vue）
* 退出页面时提示（浏览器上可以监听 beforeunload 事件，但是微信上不行）

## 心得与遗憾

* 要是在写代码之前先认认真真地把项目各个模块的流程图（或逻辑流程图）先画出来的话，感觉写代码效率会大大提高。（或者说写代码之前先把产品整体的构思与架构先画个图表示出来）
* 遗憾是，项目虽然引入了 vue-router，但是基本上没用到，整个页面都是基于事件开发出来的，没有路由，那就下个项目再用 vue-router 吧 ~

## Licence

MIT Licence
