<?php
namespace admin\controllers;

/**
 * controller
 */
class Controller extends \yii\web\Controller
{

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if(parent::beforeAction($action)){
            return true;
        }

        return false;
    }
}
