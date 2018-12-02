# image
Laravel Image is an image manipulation package for Laravel. It supports basic image manipulations such as resize, watermark.

### Installing
```
composer require ratulhasan/image
```

### Usage
```
\RatulHasan\Image\Image::createThumb('upload file', 'extension', 'destination where to save image', 'desired_width', 'desired_height')
```

```
\RatulHasan\Image\Image::watermark($target, $watermark_file, $position)
```