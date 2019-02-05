<?php
return [
    'name' => 'Microwave Electronics Department',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    /*'aliases' => [
            '@images' => '@app/images',
        ],*/
 
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['admin', 'head', 'manager', 'Purchasegroup'],
        ],
    ],
];
