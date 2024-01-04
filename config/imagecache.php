<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Name of route
    |--------------------------------------------------------------------------
    |
    | Enter the routes name to enable dynamic imagecache manipulation.
    | This handle will define the first part of the URI:
    |
    | {route}/{template}/{filename}
    |
    | Examples: "images", "img/cache"
    |
    */

    'route' => "images",

    /*
    |--------------------------------------------------------------------------
    | Storage paths
    |--------------------------------------------------------------------------
    |
    | The following paths will be searched for the image filename, submited
    | by URI.
    |
    | Define as many directories as you like.
    |
    */

    'paths' => array(
        public_path('content'),
        public_path('users_avatar'),
        public_path('products'),
        public_path('pairing'),
        public_path('brend'),
    ),

    /*
    |--------------------------------------------------------------------------
    | Manipulation templates
    |--------------------------------------------------------------------------
    |
    | Here you may specify your own manipulation filter templates.
    | The keys of this array will define which templates
    | are available in the URI:
    |
    | {route}/{template}/{filename}
    |
    | The values of this array will define which filter class
    | will be applied, by its fully qualified name.
    |
    */

    'templates' => array(
        'backendSmall' => 'App\Filters\Image\BackendSmall',
        'icon' => 'App\Filters\Image\Icon',
        'avatar' => 'App\Filters\Image\Avatar',
        'productList' => 'App\Filters\Image\ProductList',
        'productAdmin' => 'App\Filters\Image\ProductAdmin',
        'productItem' => 'App\Filters\Image\ProductItem',
        'productMid' => 'App\Filters\Image\ProductMid',
        'productSmall' => 'App\Filters\Image\ProductSmall',
        'blogItem' => 'App\Filters\Image\BlogItem',
        'blogSingleItem' => 'App\Filters\Image\BlogSingleItem',
        'dealSidebarSmall' => 'App\Filters\Image\DealSidebarSmall',
        'dealSidebarBig' => 'App\Filters\Image\DealSidebarBig',
        'homeMiddel' => 'App\Filters\Image\HomeMiddel',
        'addressItem' => 'App\Filters\Image\AddressItem',
        'productThumb' => 'App\Filters\Image\ProductThumb',
        'metaThumb' => 'App\Filters\Image\MetaThumb',
        'slider' => 'App\Filters\Image\Slider',
    ),

    /*
    |--------------------------------------------------------------------------
    | Image Cache Lifetime
    |--------------------------------------------------------------------------
    |
    | Lifetime in minutes of the images handled by the imagecache route.
    |
    */

    'lifetime' => 43200,

);
