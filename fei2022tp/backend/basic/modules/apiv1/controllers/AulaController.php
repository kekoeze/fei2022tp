<?php

namespace app\modules\apiv1\controllers;

use yii\rest\ActiveController;

use yii\web\Response;
use yii\filters\ContentNegotiator;

use yii\filters\Cors;

/**
 * Default controller for the `apiv1` module
 */
class AulaController extends ActiveController
{

    public $modelClass = 'app\modules\models\Aula';
    public static function allowedDomains()
    {
        return [$_SERVER["REMOTE_ADDR"], 'http://localhost:8080'];
    }

    function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return array_merge($behaviors, [
            'corsFilter'  => [
                'class' => Cors::class,
                'cors'  => [
                    // restrict access to domains:
                    'Origin'                           => static::allowedDomains(),
                    'Access-Control-Request-Method'    => ['POST', 'GET', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
                    'Access-Control-Allow-Headers' => ['authorization', 'X-Requested-With', 'content-type', 'some_custom_header'],
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page', 'X-Pagination-Page-Count', 'X-Pagination-Total-Count']
                ],
            ],
        ]);
        return $behaviors;
    }
}
