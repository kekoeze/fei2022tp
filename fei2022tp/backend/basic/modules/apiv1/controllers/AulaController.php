<?php

namespace app\modules\apiv1\controllers;

use yii\rest\ActiveController;

/**
 * Default controller for the `apiv1` module
 */
class AulaController extends ActiveController
{

    public $modelClass = 'app\modules\models\Aula';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
