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
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<parentSectionId:\d+>-<parentSectionSlug:[\w\-]+>/<childSectionId:\d+>-<childSectionSlug:[\w\-]+>/<id:\d+>-<slug:[\w\-]+>' => 'post/view',
                '<parentId:\d+>-<parentSlug:[\w\-]+>/<id:\d+>-<slug:[\w\-]+>' => 'section/view',
                '<id:\d+>-<slug:[\w\-]+>' => 'section/view',
            ],
        ],
    ],
    'params' => $params,
];
