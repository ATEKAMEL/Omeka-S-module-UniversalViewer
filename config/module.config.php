<?php
namespace UniversalViewer;

return [
    'view_manager' => [
        'template_path_stack' => [
            OMEKA_PATH . '/modules/UniversalViewer/view',
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'universalViewer' => Service\ViewHelper\UniversalViewerFactory::class,
        ],
    ],
    'block_layouts' => [
        'invokables' => [
            'universalViewer' => Site\BlockLayout\UniversalViewer::class,
        ],
    ],
    'controllers' => [
        'invokables' => [
            'UniversalViewer\Controller\Player' => Controller\PlayerController::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            'UniversalViewer\Form\Config' => Service\Form\ConfigFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'universalviewer_player' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/:resourcename/:id/play',
                    'constraints' => [
                        'resourcename' => 'item|item\-set',
                        'id' => '\d+',
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'UniversalViewer\Controller',
                        'controller' => 'Player',
                        'action' => 'play',
                    ],
                ],
            ],

            // If really needed, the next route may be uncommented to keep
            // compatibility with the old schemes used by the plugin for Omeka 2
            // before the version 2.4.2.
            // 'universalviewer_player_classic' => [
            //     'type' => 'segment',
            //     'options' => [
            //         'route' => '/:resourcename/play/:id',
            //         'constraints' => [
            //             'resourcename' => 'item|items|item\-set|item_set|collection|item\-sets|item_sets|collections',
            //             'id' => '\d+',
            //         ],
            //         'defaults' => [
            //             '__NAMESPACE__' => 'UniversalViewer\Controller',
            //             'controller' => 'Player',
            //             'action' => 'play',
            //         ],
            //     ],
            // ],
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
                'text_domain' => null,
            ],
        ],
    ],
];
