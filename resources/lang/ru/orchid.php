<?php

return [
    'menu'        => [
        'program' => 'Учебная программа',
        'levels'  => 'Уровни'
    ],
    'pages'       => [
        'level' => [
            'index'  => 'Уровни',
            'create' => 'Создание уровня',
            'update' => 'Редактирование уровня',
            'show'   => 'Уровень',
            'delete' => 'Удаление уровня'
        ]
    ],
    'links'       => [
        'index'  => 'Список',
        'create' => 'Создать',
        'update' => 'Редактировать',
        'show'   => 'Показать',
        'delete' => 'Удалить'
    ],
    'models'      => [
        'level'   => [
            'code'     => 'Код',
            'title'    => 'Название',
            'priority' => 'Приоритет'
        ],
        'default' => [
            'created_at' => 'Дата создания',
            'updated_at' => 'Последнее редактирование'
        ]
    ],
    'permissions' => [
        'lessons' => 'Уроки',
        'levels'  => 'Рівні',
    ],
    'roles'       => [
        'study' => 'Учебная программа'
    ],
    'toasts'      => [
        'actions' => [
            'saved'   => 'Запись сохранена',
            'deleted' => 'Запись удалена',
        ]
    ]
];
