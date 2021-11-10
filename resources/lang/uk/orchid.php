<?php

return [
    'menu'        => [
        'program' => 'Навчальна програма',
        'levels'  => 'Рівні'
    ],
    'pages'       => [
        'level' => [
            'index'  => 'Рівні',
            'create' => 'Створення рівня',
            'update' => 'Редагування рівня',
            'show'   => 'Рівнень',
            'delete' => 'Видалення рівня'
        ]
    ],
    'links'       => [
        'index'  => 'Список',
        'create' => 'Створити',
        'update' => 'Редагувати',
        'show'   => 'Показати',
        'delete' => 'Видалити'
    ],
    'models'      => [
        'level'   => [
            'code'     => 'Код',
            'title'    => 'Назва',
            'priority' => 'Пріорітет'
        ],
        'default' => [
            'created_at' => 'Дата створення',
            'updated_at' => 'Останнє редагування'
        ]
    ],
    'permissions' => [
        'lessons' => 'Уроки',
        'levels'  => 'Рівні'
    ],
    'roles'       => [
        'study' => 'Навчальна програма'
    ],
    'toasts'      => [
        'actions' => [
            'saved'   => 'Запис збережено',
            'deleted' => 'Запис видалено',
        ]
    ]
];
