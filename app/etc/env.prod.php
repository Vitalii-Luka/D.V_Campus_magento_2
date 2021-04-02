<?php
return [
    'backend' => [
        'frontName' => 'admin'
    ],
    'queue' => [
        'consumers_wait_for_messages' => 1
    ],
    'crypt' => [
        'key' => '0340e0f53a19fcdb4dbd4d44ecd17545'
    ],
    'db' => [
        'table_prefix' => 'm2_',
        'connection' => [
            'default' => [
                'host' => 'mysql',
                'dbname' => 'vitalii_luka_local',
                'username' => 'vitalii_luka_local',
                'password' => 'vitalii_luka_local',
                'model' => 'mysql4',
                'engine' => 'innodb',
                'initStatements' => 'SET NAMES utf8;',
                'active' => '1',
                'driver_options' => [
                    1014 => false
                ]
            ]
        ]
    ],
    'resource' => [
        'default_setup' => [
            'connection' => 'default'
        ]
    ],
    'x-frame-options' => 'SAMEORIGIN',
    'MAGE_MODE' => 'production',
    'session' => [
        'save' => 'redis',
        'redis' => [
            'host' => 'redis',
            'port' => '6379',
            'password' => '',
            'timeout' => '2.5',
            'persistent_identifier' => '',
            'database' => '2',
            'compression_threshold' => '2048',
            'compression_library' => 'gzip',
            'log_level' => '4',
            'max_concurrency' => '6',
            'break_after_frontend' => '5',
            'break_after_adminhtml' => '30',
            'first_lifetime' => '600',
            'bot_first_lifetime' => '60',
            'bot_lifetime' => '7200',
            'disable_locking' => '0',
            'min_lifetime' => '60',
            'max_lifetime' => '2592000'
        ]
    ],
    'cache' => [
        'frontend' => [
            'default' => [
                'backend' => 'Cm_Cache_Backend_Redis',
                'backend_options' => [
                    'server' => 'redis',
                    'database' => '0',
                    'port' => '6379',
                    'compress_data' => '1',
                    'compression_lib' => 'gzip'
                ]
            ],
            'page_cache' => [
                'backend' => 'Cm_Cache_Backend_Redis',
                'backend_options' => [
                    'server' => 'redis',
                    'port' => '6379',
                    'database' => '1',
                    'compress_data' => '1',
                    'compression_lib' => 'gzip'
                ]
            ]
        ],
        'allow_parallel_generation' => false
    ],
    'lock' => [
        'provider' => 'db',
        'config' => [
            'prefix' => null
        ]
    ],
    'cache_types' => [
        'config' => 1,
        'layout' => 1,
        'block_html' => 1,
        'collections' => 1,
        'reflection' => 1,
        'db_ddl' => 1,
        'compiled_config' => 1,
        'eav' => 1,
        'customer_notification' => 1,
        'config_integration' => 1,
        'config_integration_api' => 1,
        'full_page' => 1,
        'config_webservice' => 1,
        'translate' => 1,
        'vertex' => 1
    ],
    'downloadable_domains' => [
        'vitalii-luka.local'
    ],
    'install' => [
        'date' => 'Fri, 23 Oct 2020 13:42:23 +0000'
    ],
    'system' => [
        'default' => [
            'web' => [
                'unsecure' => [
                    'base_url' => 'https://vitalii-luka.local/',
                    'base_link_url' => '{{unsecure_base_url}}',
                    'base_static_url' => 'https://vitalii-luka.local/static/',
                    'base_media_url' => 'https://vitalii-luka.local/media/'
                ],
                'secure' => [
                    'base_url' => 'https://vitalii-luka.local/',
                    'base_link_url' => '{{secure_base_url}}',
                    'base_static_url' => 'https://vitalii-luka.local/static/',
                    'base_media_url' => 'https://vitalii-luka.local/media/'
                ]
            ]
        ],
        'websites' => [
            'base' => [
                'general' => [
                    'locale' => [
                        'code' => 'uk_UA'
                    ]
                ],
                'design' => [
                    'theme' => [
                        'theme_id' => 4
                    ]
                ]
            ],
            'additional_website' => [
                'web' => [
                    'unsecure' => [
                        'base_url' => 'https://vitalii-luka-additional.local/',
                        'base_link_url' => 'https://vitalii-luka-additional.local/',
                        'base_static_url' => 'https://vitalii-luka-additional.local/static/',
                        'base_media_url' => 'https://vitalii-luka-additional.local/media/'
                    ],
                    'secure' => [
                        'base_url' => 'https://vitalii-luka-additional.local/',
                        'base_link_url' => 'https://vitalii-luka-additional.local/',
                        'base_static_url' => 'https://vitalii-luka-additional.local/static/',
                        'base_media_url' => 'https://vitalii-luka-additional.local/media/'
                    ]
                ]
            ]
        ]
    ]
];
