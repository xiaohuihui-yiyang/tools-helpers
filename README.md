# tools-helpers
php 开发一些日常的工具

该工具包主要提供一下日常开发中 对文件，数组，字符串，http请求，以及数据序列化的工具类
解决日常开发一些问题

例如
判断当前请求是否https请求
RequestHelpers::IsHttps();
ip 工具类：
获取当前ip版本 ipv4和ipv6
IpHelper::getIpVersion()

文件工具类：
递归创建文件夹
FileHelpers::MakeDir($pathname, $mode = 0777);
//
FileHelpers::Download($url, $file)


