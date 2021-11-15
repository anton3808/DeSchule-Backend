<?php

return [
    'menu'        => [
        'program'              => 'Навчальна програма',
        'levels'               => 'Рівні',
        'lessons'              => 'Уроки',
        'lesson_element_types' => 'Типи елементів уроку',
        'lesson_elements'      => 'Елементи уроку',
    ],
    'pages'       => [
        'level'                => [
            'index'  => 'Рівні',
            'create' => 'Створення рівня',
            'update' => 'Редагування рівня',
            'show'   => 'Рівень',
            'delete' => 'Видалення рівня'
        ],
        'lesson'               => [
            'index'  => 'Уроки',
            'create' => 'Створення уроку',
            'update' => 'Редагування уроку',
            'show'   => 'Урок',
            'delete' => 'Видалення уроку'
        ],
        'lesson_element_types' => [
            'index'  => 'Типи елементів уроку',
            'create' => 'Створення типу елемента уроку',
            'update' => 'Редагування типу елемента уроку',
            'show'   => 'Тип елемента уроку',
            'delete' => 'Видалення типу елемента уроку'
        ],
        'lesson_elements'      => [
            'index'  => 'Елементи уроку',
            'create' => 'Створення елемента уроку',
            'update' => 'Редагування елемента уроку',
            'show'   => 'Елемент уроку',
            'delete' => 'Видалення елемента уроку'
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
        'level'                => [
            'code'     => 'Код',
            'title'    => 'Назва',
            'priority' => 'Пріорітет'
        ],
        'lesson'               => [
            'order' => 'Порядок',
            'title' => 'Назва',
            'level' => 'Рівень',
        ],
        'lesson_elements'      => [
            'icon'         => 'Іконка',
            'element_type' => 'Тип',
            'title'        => 'Назва',
            'description'  => 'Опис'
        ],
        'lesson_element_types' => [
            'slugs'       => [
                'read_and_translate' => [
                    'title'       => 'Прочитай та переклади',
                    'description' => 'Прочитай текст вголос і спробуй перекласти.  Якщо трапляється незнайоме слово- ти завжди можеш подивитись його у словнику!'
                ]
            ],
            'title'       => 'Назва',
            'description' => 'Опис'
        ],
        'default'              => [
            'created_at' => 'Дата створення',
            'updated_at' => 'Останнє редагування'
        ]
    ],
    'permissions' => [
        'lessons'              => 'Уроки',
        'levels'               => 'Рівні',
        'lesson_element_types' => 'Типи елементів уроку',
        'lesson_elements'      => 'Елементи уроку'
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
