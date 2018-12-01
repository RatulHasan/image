<?php

Route::get('/', function () {
    echo 'Hello from the image package!';
});

Route::get('add/{a}/{b}', 'RatulHasan\Image\ImageController@add');