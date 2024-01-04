<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class MetaThumb implements FilterInterface
{
    public function applyFilter(Image $image)
    {
    	return $image->fit(1200, 627, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }
}