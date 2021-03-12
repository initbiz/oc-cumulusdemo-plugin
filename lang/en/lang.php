<?php return [
    'plugin' => [
        'name' => 'Cumulus Demo Plugin',
        'description' => 'Demonstration plugin for CumulusCore based application',
    ],
    'features' => [
        'basic_dashboard' => 'Free dashboard',
        'basic_dashboard_desc' => '',
        'basic_todo' => 'Basic ToDo',
        'basic_todo_desc' => '',
        'basic_gallery' => 'Basic gallery',
        'basic_gallery_desc' => '',
        'advanced_dashboard' => 'Advenced dashboard',
        'advanced_dashboard_desc' => '',
        'advanced_gallery' => 'Advenced gallery',
        'advanced_gallery_desc' => '',
        'advanced_todo' => 'Advenced ToDo',
        'advanced_todo_desc' => '',
    ],
    'exceptions' => [
        'todo_error' => 'You have reached the limit. Upgrade your plan to add more'
    ],
    'components' => [
        'todo' => [
            'name' => 'To Do List',
            'add_button' => 'Add',
            'value' => 'What needs to be done?',
        ],
    ]
];
