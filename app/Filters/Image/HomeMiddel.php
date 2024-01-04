<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class HomeMiddel implements FilterInterface
{
    public function applyFilter(Image $image)
    {
    	return $image->fit(1198, 138, function ($constraint) {
            $constraint->aspectRatio();
		    $constraint->upsize();
		});
    }
}