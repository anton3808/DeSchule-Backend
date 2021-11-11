<?php

return [
    'menu'        => [
        'program' => 'Навчальна програма',
        'levels'  => 'Рівні',
        'lessons' => 'Уроки'
    ],
    'pages'       => [
        'level'  => [
            'index'  => 'Рівні',
            'create' => 'Створення рівня',
            'update' => 'Редагування рівня',
            'show'   => 'Рівень',
            'delete' => 'Видалення рівня'
        ],
        'lesson' => [
            'index'  => 'Уроки',
            'create' => 'Створення уроку',
            'update' => 'Редагування уроку',
            'show'   => 'Урок',
            'delete' => 'Видалення уроку'
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
        'lesson'  => [
            'order' => 'Порядок',
            'title' => 'Назва',
            'level' => 'Рівень',
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
