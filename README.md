# php-web-nginx-capatcha-noise-fisheye-distorion

## Description
This is a simple images only
capatcha, this is not ment for
production. Changed dot and line
noise to a single function. Also
added fisheye distorion.

This renders SLOWLY b/c of the
fisheye distorion.

## Tech stack
- PHP

## Docker stack
- nginx:latest
- php:fpm
-
## To run
`sudo ./install.sh -u`
- http://localhost

## To stop
`sudo ./install.sh -d`

## For help
`sudo ./install.sh -h`

## Credits
- [Docker setup] (https://github.com/mikechernev/dockerised-php)
- [Docker install php gd lib] (https://stackoverflow.com/questions/61228386/installing-gd-extension-in-docker)
- [PHP image creation] (https://www.codexworld.com/create-dynamic-image-text-php/)
- [Dot and line noise] (https://fisheye.i4ware.fi/browse/~br=trunk/Open_Source_Timesheet/trunk/zf/library/Zend/Captcha/Image.php?r2=2120&ignore=Bb&r=2120&u=100&r1=2119)
- [Fisheye distorion] (https://stackoverflow.com/questions/6021894/draw-text-with-custom-font-using-imagemagick-and-php)
