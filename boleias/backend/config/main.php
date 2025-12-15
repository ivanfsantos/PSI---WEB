<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            //'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'api/user',
                        'api/viatura',
                        'api/reserva',
                        'api/perfil',
                        'api/documento',
                        'api/destinofavorito',
                        'api/boleia',
                        'api/avaliacao',
                    ],
                    'extraPatterns' => [
                        'GET count' => 'count', // 'count' é 'actionCount' e serve para contar os registos de cada modelo
                        'GET usernames' => 'nomes', // 'usernames' é 'actionUsernames' e serve para mostrar todos os usernames registados
                        'GET emails' => 'emails', // 'emails' é 'actionEmails' e serve para mostrar todos os emails registados
                        'GET marcas' => 'marcas', // 'marcas' é 'actionMarcas' e serve para mostrar todas as marcas registadas
                        'GET modelos' => 'modelos', // 'modelos' é 'actionModelos' e serve para mostrar todos os modelos registados
                        'GET matriculas' => 'matriculas', // 'matriculas' é 'actionMatriculas' e serve para mostrar todas as matriculas registadas
                        'GET cores' => 'cores', // 'cores' é 'actionCores' e serve para mostrar todas as cores registadas
                        'GET lugaresdisponiveis' => 'lugaresdisponiveis', // 'lugaresdisponiveis' é 'actionLugaresdisponiveis' e serve para mostrar todos os lugares disponíveis registados
                        'GET nomes' => 'nomes', // 'nomes' é 'actionNomes' e serve para mostrar todos os nomes registados
                        'GET telefones' => 'telefones', // 'telefones' é 'actionTelefones' e serve para mostrar todos os numeros de telefone registadas
                        'GET moradas' => 'moradas', // 'moradas' é 'actionMoradas' e serve para mostrar todas as moradas registadas
                        'GET generos' => 'generos', // 'generos' é 'actionGeneros' e serve para mostrar todos os generos registados
                        'GET datasnascimentos' => 'datasnascimentos', // 'datasnascimentos' é 'actionDatasnascimento' e serve para mostrar todas as datas de nascimento registadas
                        'GET mensagens' => 'mensagens', // 'mensagens' é 'actionMessagens' e serve para mostrar todas as mensagens registadas
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
