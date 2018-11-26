# 图片增加盲水印演示(PHP版)

## 使用方法

```sh
docker run -d --rm -p 80:80 -v "$PWD/www-data":/home/www-data -w /home/www-data fatindeed/php:imagick php -S 0.0.0.0:80
```

打开浏览器`http://<docker-host>`演示

## 常见问题

1.  关于字体和字符集

    默认镜像中只有一个 *Arial* 字体，如需显示其它字符集（如中文），请手动复制字体文件到`www-data/fonts`目录，演示页面即会出现该字体选项，选择它即可。

## 参考资料

- [阿里根据截图查到泄露者，这样的技术是如何做到的？](http://blog.jobbole.com/105968/)
- [用ImageMagick实现数字盲水印](http://ju.outofmemory.cn/entry/343643)
- [PHP: Imagick::forwardFourierTransformImage - Manual](http://php.net/manual/zh/imagick.forwardfouriertransformimage.php)
- [Fourier Transforms -- IM v6 Examples](http://www.imagemagick.org/Usage/fourier/)
