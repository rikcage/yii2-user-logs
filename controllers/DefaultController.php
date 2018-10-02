<?php

namespace common\modules\dblogs\controllers;

use yii\web\Controller;

/**
 * Default controller for the `bdlogs` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->goHome();
        //return $this->render('index');
    }
}
