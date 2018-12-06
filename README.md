# image
**Image** package is an image manipulation package for **PHP**. It supports basic image manipulations such as resize, watermark. You can use this package with any **PHP** projects.

### Installing
```
composer require ratulhasan/image
```

### Usage

```
$image_file = 'upload_file.jpg'
$destination = 'uploaded_path/upload_file.jpg'
$desired_width = 600 (optional)
$desired_height = 600 (optional)
```

```
\RatulHasan\Image\Image::createThumb($image_file, $destination, $desired_width, $desired_height)
```


```
$target = 'uploaded_path/upload_file.jpg'
$watermark_file = 'watermark_file.png' (supports only png file)
```
```
\RatulHasan\Image\Image::watermark($target, $watermark_file)
```
