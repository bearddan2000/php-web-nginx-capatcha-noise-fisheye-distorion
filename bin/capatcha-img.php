<?php
// Specify font path
$font = 'fonts/verdanab.ttf';

// Text font size
$font_size = 24;

// Get settings from URL
$setting = isset($_GET['s']) ? $_GET['s'] : "000_FFF_350_350";
$setting = explode("_", $setting);

$img = array();

// Define image width, height, and color
switch ($n = count($setting)) {
    case $n > 4:
    case 3:
        $setting[3] = $setting[2];
        // no break
    case 4:
        $img['width'] = (int) $setting[2];
        $img['height'] = (int) $setting[3];
        // no break
    case 2:
        $img['background'] = $setting[0];
        $img['color'] = $setting[1];
        break;
    default:
        list($img['background'], $img['color'], $img['width'], $img['height']) = array('F', '0', 100, 100);
        break;
}
$background = explode(",", hex2rgb($img['background']));
$textColorRgb = explode(",", hex2rgb($img['color']));
$width = empty($img['width']) ? 100 : $img['width'];
$height = empty($img['height']) ? 100 : $img['height'];

// Get text from URL
$text = (string) isset($_GET['t']) ? urldecode($_GET['t']) : $width ." x ". $height;

/*
$noise_type: This parameter is used to set the noise types. There are some noise constants available in Imagick function which are listed below:
    imagick::NOISE_UNIFORM
    imagick::NOISE_GAUSSIAN
    imagick::NOISE_MULTIPLICATIVEGAUSSIAN
    imagick::NOISE_IMPULSE
    imagick::NOISE_LAPLACIAN
    imagick::NOISE_POISSON
    imagick::NOISE_RANDOM

This constant supports on ImageMagick version 6.3.6 and above.
$channel: This parameter provides the channel constants. Two or more channel can be combined using bitwise operator. There are some channel constants available in Imagick function which are listed below:
    imagick::CHANNEL_UNDEFINED
    imagick::CHANNEL_RED
    imagick::CHANNEL_GRAY
    imagick::CHANNEL_CYAN
    imagick::CHANNEL_GREEN
    imagick::CHANNEL_MAGENTA
    imagick::CHANNEL_BLUE
    imagick::CHANNEL_YELLOW
    imagick::CHANNEL_ALPHA
    imagick::CHANNEL_OPACITY
    imagick::CHANNEL_MATTE
    imagick::CHANNEL_BLACK
    imagick::CHANNEL_INDEX
    imagick::CHANNEL_ALL
    imagick::CHANNEL_DEFAULT
*/

/* Create some objects */
$image = new Imagick();
$draw = new ImagickDraw();
$pixel = new ImagickPixel('white');

/* New image */
$image->newImage($width, $height, $pixel);

/* Black text */
$draw->setFillColor('gray');

/* Font properties */
$draw->setFont($font);
$draw->setFontSize($font_size);

/* Create text */
$image->annotateImage(
    $draw,
    50,
    100,
    0,
    $text
);

/* Give image a format */
$image->setImageFormat('png');

// add noise
$image->addNoiseImage(3, imagick::CHANNEL_DEFAULT);

/* This is the expression that define how to do the fisheye effect */

$distort_expression =
'kk=w*0.5;
ll=h*0.5;
dx=(i-kk);
dy=(j-ll);
aa=atan2(dy,dx);
rr=hypot(dy,dx);
rs=rr*rr/hypot(kk,ll);
px=kk+rs*cos(aa);
py=ll+rs*sin(aa);
p{px,py}';

// Perform the distortion
$image = $image->fxImage($distort_expression);

header('Content-Type: image/png');
echo $image;
// Convert color code to rgb
function hex2rgb($hex)
{
    $hex = str_replace("#", "", $hex);

    switch (strlen($hex)) {
        case 1:
            $hex = $hex.$hex;
            // no break
        case 2:
            $r = hexdec($hex);
            $g = hexdec($hex);
            $b = hexdec($hex);
            break;
        case 3:
            $r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
            break;
        default:
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
            break;
    }

    $rgb = array($r, $g, $b);
    return implode(",", $rgb);
}
