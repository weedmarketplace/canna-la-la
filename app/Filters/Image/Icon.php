<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Icon implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(20, 20, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }
}