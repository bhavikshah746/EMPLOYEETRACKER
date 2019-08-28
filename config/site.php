<?php
return [
    'user_roles' => [
        '1' => 'Super Admin',
        '2' => 'Admin',
        '3' => 'Sales Person'
    ],
    'responces' => [
        'tasks_salesperson_responce' => [
            '0' => 'Uncomplete',
            '1' => 'Complete'
        ],
        'tasks_admin_responce' => [
            '0' => 'Rejected',
            '1' => 'Approved'
        ]
    ],
    'order_status' => [
        '0' => 'Open',
        '1' => 'Close'
    ],
    'api_limit' => 10,
    'noti_limit' => 10,
    'salesperson_types' => [
        '1' => 'Domestic',
        '2' => 'International'
    ],
    'product_type' => [
        '1' => 'Laminate',
        '2' => 'MDF'
    ],
    'app_login' => [
        'domestic' => [
            'start' => '10:15',
            'end' => '7:15'
        ],
        'international' => [
            'start' => '23:55',
            'end' => ''
        ]
    ],
    'client_type' => [
        '1' => 'Dealer ',
        '2' => 'Distributor',
        '3' => 'C&F Agent',
        '4' => 'hospitals',
        '5' => 'retailers',
        '6' => 'super stockist',
    ],
    'expance' => [
        '1' => 'Food',
        '2' => 'Mobile',
        '3' => 'Travel',
        '4' => 'Courier',
        '5' => 'Miscellaneous',
        '6' => 'Lodging'
    ],
    'expance_status' => [
        '0' => 'Rejected',
        '1' => 'Approved',
        '2' => 'Pending'
    ],

    'expance_alert' => 10,

    'particlulars' => [
        '1' => 'PLAIN',
        '2' => 'OSR',
        '3' => 'BSB',
        '4' => 'OSL',
        '5' => 'BSL'
    ],

    'finsish' => [
        '1' => 'MATT',
        '2' => 'SF'
    ],

    'grade' => [
        '1' => 'INT. DIAMOND',
        '2' => 'EXT. DIAMOND',
        '3' => 'INT. CRYSTAL',
        '4' => 'EXT. CRYSTAL',
        '5' => 'INT. B',
        '6' => 'EXT. B',
        '7' => 'INT. FRT',
        '8' => 'EXT. FRT'
    ]
];