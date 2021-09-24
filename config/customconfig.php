<?php

// if(!function_exist(url_origin)){
    function url_origin($s, $use_forwarded_host = false) {
    if (isset($s['SERVER_PROTOCOL'])) {
        $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on');
        $sp = strtolower($s['SERVER_PROTOCOL']);
        $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
        $port = $s['SERVER_PORT'];
        $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
        $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
        $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
        return $protocol . '://' . $host;
    }
    return '';
}
// }

if (isset($_SERVER) && count($_SERVER)) {
    $server_url_path = $_SERVER['DOCUMENT_ROOT'];
    $absolute_url = url_origin($_SERVER, false);
    if ($absolute_url == 'http://localhost' || $absolute_url == env('APP_HOST') || (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'manage.getkeyapp.com')) {
        $absolute_url = env('APP_URL') . '/';
    } else {
        $absolute_url = $absolute_url . '/';
    }
}

if ($absolute_url == '/') {
    $absolute_url = env('APP_URL') . '/';
}
$absolute_url .= 'storage/'; 
$absolute_doc_path = storage_path() . '/app/public/';

return [

    "path" => [
        //HTTP URL Paths [Eg. get image]
        //http://localhost:8000/storage/app/public/
        "url" => [
            'banner' => $absolute_url.'banner/',
            'page' => $absolute_url.'page/',
            'product' => $absolute_url.'product/',
            'category' => $absolute_url.'category/',
            'blog' => $absolute_url.'blog/',
            'blogcat' => $absolute_url.'blogcat/',
            'faq' => $absolute_url.'faq/',
            'faqcat' => $absolute_url.'faqcat/',
            'contact' => $absolute_url.'contact/',
            'staticimage' => $absolute_url.'staticimage/',
            'newslettermessage' => $absolute_url.'newslettermessage/',
            'logo' => $absolute_url.'logo/',
        ],

        //Storage Document Paths [Eg. store image]
        // /var/www/html/project_name/storage/
        "doc" => [
            'banner' => $absolute_doc_path.'banner/',
            'page' => $absolute_doc_path.'page/',
            'product' => $absolute_doc_path.'product/',
            'category' => $absolute_doc_path.'category/',
            'blog' => $absolute_doc_path.'blog/',
            'blogcat' => $absolute_doc_path.'blogcat/',
            'faq' => $absolute_doc_path.'faq/',
            'faqcat' => $absolute_doc_path.'faqcat/',
            'contact' => $absolute_doc_path.'contact/',
            'staticimage' => $absolute_doc_path.'staticimage/',
            'newslettermessage' => $absolute_doc_path.'newslettermessage/',
            'logo' => $absolute_doc_path.'logo/',
            // "testimonial_images" => $uploadsDocPath."testimonial-images/",
        ]

    ],
    'settings_type' => [
        'Setting_general',
        'Setting_order_email',
        'Setting_contact_email',
        'Setting_social_configuration',
        'Setting_newsletter_type',
        'Setting_ecommerce_function',
        'Setting_server_API',
    ],

    'image' => [
        'module_name' => [
            'Banner'=> 'Banner',
            'Category'=> 'Category',
            'Product'=> 'Product',
            'Page'=> 'Page',
            'AboutUs'=> 'AboutUs',
            'BreadcrumbBanner' => 'BreadcrumbBanner',
            'Faq'=> 'Faq',
            'FaqCategory'=> 'FaqCategory',
            'Blog'=> 'Blog',
            'BlogCategory'=> 'BlogCategory',
            'Certificate'=> 'Certificate',
            'Contact'=> 'Contact',
            'Newsletter_image' => 'Newsletter_image'
        ],
        'thumb_folder' => [
            'big' =>'big',
            'medium'=>'medium',
            'small'=>'small',
            'tiny'=>'tiny',
            // 'original' => 'original',
        ]
    ]
];
