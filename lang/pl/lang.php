<?php return [
    'plugin' => [
        'name' => 'Cumulus Demo Plugin',
        'description' => 'Demonstration plugin for CumulusCore based application',
    ],
    'features' => [
        'basic_dashboard' => 'Darmowy dashboard',
        'basic_dashboard_desc' => '',
        'basic_todo' => 'Podstawowe ToDo',
        'basic_todo_desc' => '',
        'basic_gallery' => 'Podstawowa galeria',
        'basic_gallery_desc' => '',
        'advenced_dashboard' => 'Zawansowany dashboard',
        'advenced_dashboard_desc' => '',
        'advenced_gallery' => 'Zawansowana galeria',
        'advenced_gallery_desc' => '',
        'advenced_todo' => 'Zawansowane ToDo',
        'advenced_todo_desc' => '',
    ],
    'exceptions' => [
        'todo_error' => 'Wyczerpałeś limit. Podnieś swój plan aby dodać więcej',
    ],
    'components' => [
        'todo' => [
            'name' => 'Lista To Do',
            'add_button' => 'Dodaj',
            'value' => 'Co musi być zrobione?',
            ]
    ]
];
