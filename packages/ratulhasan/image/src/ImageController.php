<?php

namespace RatulHasan\Image;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function add( $a, $b )
    {
        echo $a + $b;
    }

}