<?php

return [

    'thumb_size' => '_sm',
    'web_size' => '_md',

    'thumb_sizes' => [

        'small' => [
            'height'                => 300,
            'width'                 => 300,
            'prefix'                => '_sm',
        ],

        'large' => [
            'height'                => 750,
            'width'                 => 750,
            'prefix'                => '_md',
        ],

    ],

    'image_extensions' => ['jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'webp'],

    'thumb_extension' => 'jpg',

    'disk' => 'product_image',

    'storage_folder' => 'products',
];