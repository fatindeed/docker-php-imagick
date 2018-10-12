# 图片增加盲水印演示

[![Docker Stars](https://img.shields.io/docker/stars/fatindeed/php-imagick.svg)](https://hub.docker.com/r/fatindeed/php-imagick/) [![Docker Pulls](https://img.shields.io/docker/pulls/fatindeed/php-imagick.svg)](https://hub.docker.com/r/fatindeed/php-imagick/) [![Docker Automated build](https://img.shields.io/docker/automated/fatindeed/php-imagick.svg)](https://hub.docker.com/r/fatindeed/php-imagick/) [![Docker Build Status](https://img.shields.io/docker/build/fatindeed/php-imagick.svg)](https://hub.docker.com/r/fatindeed/php-imagick/)

[![Download size](https://images.microbadger.com/badges/image/fatindeed/php-imagick.svg)](https://microbadger.com/images/fatindeed/php-imagick "Get your own image badge on microbadger.com") [![Version](https://images.microbadger.com/badges/version/fatindeed/php-imagick.svg)](https://microbadger.com/images/fatindeed/php-imagick "Get your own version badge on microbadger.com") [![Source code](https://images.microbadger.com/badges/commit/fatindeed/php-imagick.svg)](https://microbadger.com/images/fatindeed/php-imagick "Get your own commit badge on microbadger.com")

## 使用方法

```sh
docker run -d -p 80:80 fatindeed/php-imagick
```

打开浏览器演示

## 常见问题

1.  关于字体和字符集

    默认镜像中只有一个 *Arial* 字体，如需显示其它字符集（如中文），请手动挂载字体文件到`/home/www-data/fonts`目录，演示页面即会出现该字体选项。

    ```sh
    docker run -d -p 80:80 -v /path/to/fonts:/home/www-data/fonts fatindeed/php-imagick
    ```

## 参考资料

- [阿里根据截图查到泄露者，这样的技术是如何做到的？](http://blog.jobbole.com/105968/)
- [用ImageMagick实现数字盲水印](http://ju.outofmemory.cn/entry/343643)
- [PHP: Imagick::forwardFourierTransformImage - Manual](http://php.net/manual/zh/imagick.forwardfouriertransformimage.php)
- [Fourier Transforms -- IM v6 Examples](http://www.imagemagick.org/Usage/fourier/)
