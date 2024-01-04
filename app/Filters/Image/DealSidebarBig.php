<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class DealSidebarBig implements FilterInterface
{
    public function applyFilter(Image $image)
    {
    	return $image->fit(375, 980, function ($constraint) {
            $constraint->aspectRatio();
		    $constraint->upsize();
		});
    }
}