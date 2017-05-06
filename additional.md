
> 下面是一些前后端数据交互时比较重要的一些接口

### menu.vue

```
// menu_list
{
    '公共课': 'public_class',
    '编程': 'programming',
    '电路电子': 'electric',
    '其它': 'other_books'
}
```

### content.vue

```
// queryObj
{
    type: home,           // 记录请求时所在的分类
    // type: home(default)、public_class、programming、electric、other_books、search
    data_num: 10,         // 一次请求返回的数据个数
    request_count: 0,     // 记录请求的次数，方便实现下滑继续加载
    keyword: 'xxx'        // 搜索关键字（only for type='search'）
}
```

### scan.js || manual.js

```
{
    flag: 'in-scan',       // 记录操作的方式
    // flag: in-scan、out-scan、in-manual、out-manual
    kind: 'xxx',           // 书的分类
    title: 'xxx',          // 书名
    author: 'xxx',         // 作者
    imageSrc || imageFile  // 封面图片（链接或文件）
    number: 10             // 书的数量
}
```

### operate.php

```php
$way                // 'scan' || 'manual'
$flag               // 'in' || 'out'
$type               // 书的分类
$title              // 书名
$author             // 作者
$imageSrc           // 封面图片链接
$number             // 书籍数量
```

```php
// 检测数据库中是否存在指定书籍（使用书名和作者名进行检测书籍的唯一性）

if($flag == 'in'){
    if($way == 'scan'){
        if('书籍存在'){
            // 只更新书籍数量
        }
        if('书籍不存在'){
            // 插入新的书籍(INSERT INTO...)
        }
    }
    if($way == 'manual'){
        if('书籍存在'){
            // 处理上传的图片
            // 更新书籍所有信息
        }
        if('书籍不存在'){
            // 处理上传的图片
            // 插入新的书籍(INSERT INTO...)
        }
    }
}

if($flag == 'out'){
    if($way == 'scan'){
        if('书籍存在'){
            // 只更新书籍数量
            // 注意对书籍数量进行边界值检测
        }
        if('书籍不存在'){
            // 报错
        }
    }
    if($way == 'manual'){
        if('书籍存在'){
            // 只更新书籍数量
            // 注意对书籍数量进行边界值检测
        }
        if('书籍不存在'){
            // 报错
        }
    }
}

```
