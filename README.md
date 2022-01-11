# 介绍

这是一个基于Hyperf搭建的聊天系统，可以私聊，可以群聊，此系统只提供接口，后台前端仓库地址：https://github.com/hxs9712/hyperf-chat-admin-vue.git

# 安装前要求

Hyperf has some requirements for the system environment, it can only run under Linux and Mac environment, but due to the development of Docker virtualization technology, Docker for Windows can also be used as the running environment under Windows.

The various versions of Dockerfile have been prepared for you in the [hyperf/hyperf-docker](https://github.com/hyperf/hyperf-docker) project, or directly based on the already built [hyperf/hyperf](https://hub.docker.com/r/hyperf/hyperf) Image to run.

When you don't want to use Docker as the basis for your running environment, you need to make sure that your operating environment meets the following requirements:

- PHP >= 7.3
- Swoole PHP extension >= 4.5，and Disabled `Short Name`
- OpenSSL PHP extension
- JSON PHP extension
- PDO PHP extension （If you need to use MySQL Client）
- Redis PHP extension （If you need to use Redis Client）
- Protobuf PHP extension （If you need to use gRPC Server of Client）

# 用composer安装
```bash
git clone https://github.com/hxs9712/hyperf-chat-admin-api.git

cd hyperf-chat-admin-api

composer install
```
安装后，你可用命令运行，记得修改env配置文件
```bash
php bin/hyperf.php start
```
运行后你可以在浏览器上查看效果，链接 `http://localhost:9501/`

数据库SQL文件在根目录下，名字为hyperf-chat.sql

