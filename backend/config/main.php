<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'sourceLanguage' => 'en',
    'language' => 'en',
    'bootstrap' => ['log'],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',// 'identityClass' => 'mdm\admin\models\User',
            'enableAutoLogin' => true,
            'enableSession' => true,
            'authTimeout' => 1800,
            'loginUrl' => ['site/login'],
            'identityCookie' => [
                   'name' => '_backendIdentity',
                 //  'path' => '/admin',
                   'httpOnly' => true,
               ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'session' => [
            'name' => 'BACKENDSESSIONID',   //Set name
         //   'class' => 'yii\web\DbSession',
           // 'savePath' => __DIR__ . '/tmp', //create tmp folder and set path
      /*       'cookieParams' => [
                'httpOnly' => true,
                'path' => '/admin',
            ],*/
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            //'defaultRoles' => ['geust','admin'],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget', //в файл
                    'categories' => ['ajax'], //категория логов
                    'logFile' => '@runtime/logs/ajax.log', //куда сохранять
                    'logVars' => [] //не добавлять в лог глобальные переменные ($_SERVER, $_SESSION...)
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
           // 'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => true,
           
           // 'class'=>'frontend\components\LangUrlManager',
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['en', 'ru'],
            'rules' => [
                '/' => 'site/index',
                '<action:contact|about|login|logout>' => 'site/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            
            ],
        ],
        'request' => [
         //   'baseUrl' => '/admin',
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'csrfParam' => '_backendCSRF',
                'csrfCookie' => [
                    'httpOnly' => true,
                    'path' => '/admin',
                ],
        ],
        'assetManager' => [
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'bundles' => [
               'mimicreative\react\ReactAsset' => [
                    'js' => [
                      'react.js',
                      'react-dom.js'
                    ]
                ],
                'mimicreative\react\ReactWithAddonsAsset' => [
                    'js' => [
                      'react-with-addons.js',
                      'react-dom.js'
                    ]
                ],
            ],
           
        ],  
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                   // 'sourceLanguage' => 'en',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ]
                ],
            ],
        ],
        'view' => [
           'theme' => [
             'pathMap' => [
                '@app/views' => '@app/backend/views',//'@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app',
               //  '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/phundament/app'
             ],
           ],
        ],
     ],
   
    'modules' => [
        'user' => [
                'class' => 'dektrium\user\Module',
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'null',
           
        ],
        'main' => [
            'class' => 'app\modules\main\Module',
        ],
        'myaccount' => [
            'class' => 'app\modules\admin\MyaccountModule',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to  
            // use your own export download action or custom translation 
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
        'rbac' => [
            'class' => 'mdm\admin\Module',
             'controllerMap' => [
                 'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'common\models\Users', 
                    'idField' => 'id',
                    'usernameField' => 'username',
                  //  'fullnameField' => 'profile.full_name',
                   
                    //'searchClass' => 'app\models\UserSearch'
                ],
            ],
            'controllerMap' => [
                 'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    /* 'userClassName' => 'app\models\User', */
                    'idField' => 'id',
                    'usernameField' => 'username',
                ],
            ],
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/main.php',
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'admin/*',
            'debug/*',
          
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
    'params' => $params,
];
