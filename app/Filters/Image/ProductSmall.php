<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ProductSmall implements FilterInterface
{
    public function applyFilter(Image $image)
    {
    	return $image->fit(174, 174, function ($constraint) {
            $constraint->aspectRatio();
		    $constraint->upsize();
		});
    }
}