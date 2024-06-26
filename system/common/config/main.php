<?php
return [
    // Language
    'language' => 'id_ID',
    // Timezone
    'timeZone' => 'Asia/Jakarta',
    // Name
    'name' => 'Nexcity',

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
