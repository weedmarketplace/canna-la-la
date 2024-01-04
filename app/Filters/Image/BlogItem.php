<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class BlogItem implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(450, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }
}
