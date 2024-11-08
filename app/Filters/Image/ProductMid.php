<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ProductMid implements FilterInterface
{
    public function applyFilter(Image $image)
    {
    	return $image->fit(134, 190, function ($constraint) {
            $constraint->aspectRatio();
		    $constraint->upsize();
		});
    }
}