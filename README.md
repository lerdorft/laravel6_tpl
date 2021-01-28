## laravel6_tpl

以laravel6.2为模板，设置了常用结构，包含了一些常用方法。方便项目搭建构造。

## 本地运行

拉取项目代码到本地
```
git clone git@code.doushen-int.com:eg3/laravel6_tpl.git
```

如果本地没有安装composer，先安装composer。安装后到项目目录`double-teachers-saas-api`下，安装依赖组件。
可以将镜像源设置为国内地址，方便拉取。
```
composer config -g repo.packagist composer https://packagist.phpcomposer.com
composer install
```

生成本地env文件
```
cp .env.example .env
```

生成应用密钥
```
php artisan key:generate
```


# laravel6_tpl
