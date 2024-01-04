<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class DealSidebarSmall implements FilterInterface
{
    public function applyFilter(Image $image)
    {
    	return $image->fit(375, 586, function ($constraint) {
            $constraint->aspectRatio();
		    $constraint->upsize();
		});
    }
}