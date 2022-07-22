<?php

namespace app\modules\apiv1\controllers;

use yii\rest\ActiveController;
use yii\web\Controller;

/**
 * Default controller for the `apiv1` module
 */
class HorariomateriaController extends ActiveController
{
    public $modelClass = 'app\modules\models\HorarioMateria';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
