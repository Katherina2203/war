<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'language' => 'en',
    'sourceLanguage' => 'en',
   
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
          //  'cache' => 'cache' 
        ],
        'request' => [
          //  'class' => 'common\components\Request',
         //   'baseUrl' => '/warehouse',
           // 'baseUrl' => '/administrator' // данный адрес соответсвует с тем адресом который мы задали в .htaccess из общего рута нашего приложения.
            'enableCookieValidation' => true,
            'enableCsrfValidation' => false,
            'csrfParam' => '_csrf-frontend',
            'csrfCookie' => [
                'httpOnly' => true,
              //  'path' => '/',
            ],
          //  'web'=> '/frontend/web'
        ],
        'view' => [
           'theme' => [
             'pathMap' => [
               // '@app/views' => '@app/backend/views'
                // '@app/views' => '@app/frontend/views'
                '@app/views' => '@app/frontend/modules/views'
             ],
           ],
        ],
        
       'user' => [
            'identityClass' => 'common\models\User',// 'identityClass' => 'mdm\admin\models\User',
            'enableAutoLogin' => true,
        //    'enableSession' => true,
            'authTimeout' => 1800,
        //    'loginUrl' => ['site/login'],
            'identityCookie' => [
                   'name' => '_backendIdentity',
                   'httpOnly' => true,
               ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        
        'cache' => [
            'class' => 'yii\caching\FileCache',  
        ],
   
        'session' => [
            'name' => 'BACKENDSESSIONID', //FRONTENDID
              //  'savePath' => __DIR__ . '/tmp',
              //  'class' => 'yii\web\DbSession',
        ],

        'common' => [
            'class' => 'frontend\components\Common',
        ],
        
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            //'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => true,
           // 'enableScriptParsing' => true, 
            'class' => 'codemix\localeurls\UrlManager',
            'enableLanguagePersistence' => false,
            'languages' => ['en', 'ru'],
            'rules' => [
                '/' => 'site/index',
                '<action:contact|about|login|logout>' => 'site/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
        ],
        'urlManagerBackend' =>[
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => 'http://10.0.21.156/warehouse/backend/web/',
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
        //phpMailer
        'mail' => [
            'class'            => 'zyx\phpmailer\Mailer',
            'viewPath'         => '@common/mail',
            'useFileTransport' => false,
            'config'           => [
                'mailer'     => 'smtp',
                'host'       => 'smtp.yandex.ru',
                'port'       => '465',
                'smtpsecure' => 'ssl',
                'smtpauth'   => true,
                'username'   => 'mysmtplogin@example.ru',
                'password'   => 'mYsmTpPassword',
            ],
        ],
    ],
     'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
            // enter optional module parameters below - only if you need to  
            // use your own export download action or custom translation 
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []

         //   'class' => 'yii\i18n\PhpMessageSource',
          //  'basePath' => '@kvgrid/messages',
         //   'forceTranslation' => false
        ],
        'main' => [
            'class' => 'app\modules\main\Module',
        ],
        'myaccount' => [
            'class' => 'app\modules\myaccount',
        ],
    ],
  //  'as access' => [
   //     'class' => 'mdm\admin\components\AccessControl',
   //     'allowActions' => [
    //        'site/*',
          //  'admin/*',
           // 'some-controller/some-action',
       //     'rbac/*',
            //'/site/login/',
         //   '/elements/index',
          //  '/category/index',
          //  '/orders/index',
      //  ]
    //],
    'params' => $params,
];
