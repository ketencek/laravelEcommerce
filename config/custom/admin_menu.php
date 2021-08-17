<?php

return [
    'Dashboard' => [
        'url' => url('admin'),
        'icon' => 'dashboard'
    ],
    'Catgeory' => [
        'url' => route('admin.category.index'),
        'icon' => 'tags'
    ],
    'Country' => [
        'url' => route('admin.countries.index'),
        'icon' => 'angle-double-right'
    ],
    'Product' => [
        'url' => '',
        'icon' => 'list',
        'submenu' => [
            'Price type' => [
                'url' =>  route('admin.price-type.index'),
                'icon' => 'angle-double-right',
            ],
            'Color' => [
                'url' =>  route('admin.colors.index'),
                'icon' => 'angle-double-right',
            ],
            'Size' => [
                'url' =>  route('admin.sizes.index'),
                'icon' => 'angle-double-right',
            ],
            'Product options' => [
                'url' =>  route('admin.options.index'),
                'icon' => 'angle-double-right',
            ],
            'Product' => [
                'url' =>  route('admin.products.index'),
                'icon' => 'angle-double-right',
            ],
        ],
    ],
    'Discount' => [
        'url' => '',
        'icon' => 'gift',
        'submenu' => [
            'Discount' => [
                'url' =>  route('admin.discounts.index', ['type' => 'general']),
                'icon' => 'angle-double-right',
            ],
            'Global/User Discount' => [
                'url' => route('admin.discounts.index', ['type' => 'global-user']),
                'icon' => 'angle-double-right',
            ],
        ]
    ],
    'Users' => [
        'url' => '',
        'icon' => 'users',
        'submenu' => [
            'Admin user' => [
                'url' =>  route('admin.users.index', array('type' => 'admin')),
                'icon' => 'angle-double-right',
            ],
            'Customer user' => [
                'url' => route('admin.users.index', array('type' => 'client')),
                'icon' => 'angle-double-right',
            ],
        ]
    ],
    'Banner' => [
        'url' => '',
        'icon' => 'picture-o',
        'submenu' => [
            'Banner' => [
                'url' =>  route('admin.banner.index', ['type' => 'Banner']),
                'icon' => 'angle-double-right',
            ],
        ]
    ],
    'Pages' => [
        'url' => '',
        'icon' => 'list',
        'submenu' => [
            'About us' => [
                'url' =>  route('admin.static-page.index', ['type' => 'AboutUs']),
                'icon' => 'angle-double-right',
            ],
        ]
    ],
    'Blog' => [
        'url' => '',
        'icon' => 'list',
        'submenu' => [
            'Blog' => [
                'url' =>  route('admin.blog-categories.index'),
                'icon' => 'angle-double-right',
            ],
            // 'Comment list' => [
            //     'url'=>  route('admin.blog-categories.index'),
            //     'icon' => 'angle-double-right',
            //     ],
        ]
    ],
    'Faq' => [
        'url' => route('admin.faq-categories.index'),
        'icon' => 'list',
    ],
    'Contact' => [
        'url' => '',
        'icon' => 'list',
        'submenu' => [
            'Contact' => [
                'url' =>  route('admin.contacts.index'),
                'icon' => 'angle-double-right',
            ],
        ]
    ],
    'Newsletter' => [
        'url' => '',
        'icon' => 'envelope-o',
        'submenu' => [
            'Email' => [
                'url' =>  route('admin.newsletters.index'),
                'icon' => 'angle-double-right',
            ],
            'Message' => [
                'url' =>  route('admin.newsletter-messages.index'),
                'icon' => 'angle-double-right',
            ],
        ]
    ],
    'Settings' => [
        'url' => '',
        'icon' => 'cog',
        'submenu' => [
            'Language' => [
                'url' =>  route('admin.languages.index'),
                'icon' => 'angle-double-right',
            ],
            'Settings' => [
                'url' =>  route('admin.settingstype.list'),
                'icon' => 'angle-double-right',
            ],
            '301 Redirection' => [
                'url' =>  route('admin.redirections.index'),
                'icon' => 'angle-double-right',
            ],
        ]
    ],
    'Variable' => [
        'url' => '',
        'icon' => 'th-large',
        'submenu' => [
            'Variables' => [
                'url' =>   route('admin.variables.index', ['type' => 'OTHER']),
                'icon' => 'angle-double-right',
            ],
            'Mail Variables' => [
                'url' =>  route('admin.variables.index', ['type' => 'MAIL']),
                'icon' => 'angle-double-right',
            ],
            'APP Variables' => [
                'url' =>  route('admin.variables.index', ['type' => 'APP']),
                'icon' => 'angle-double-right',
            ],
            'Basic Variables' => [
                'url' => route('admin.variables.index', ['type' => 'BASIC']),
                'icon' => 'angle-double-right',
            ],
            'Seo Variables' => [
                'url' =>  route('admin.variables.index', ['type' => 'SEO']),
                'icon' => 'angle-double-right',
            ],
            'Routing' => [
                'url' =>  route('admin.variables.index', ['type' => 'routing']),
                'icon' => 'angle-double-right',
            ],
        ]
    ]
];
