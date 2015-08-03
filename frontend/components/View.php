<?php

namespace frontend\components;

use Yii;
use yii\web\View as BaseView;
use yii\helpers\Json;

class View extends BaseView
{
    public function init()
    {
        parent::init();

        $this->registerJs('window.appName = ' . Json::encode(Yii::$app->name) . ';', View::POS_END);
        $this->registerJs('window[' . Json::encode(Yii::$app->name) . '] = {};', View::POS_END);
    }

    public function registerJsVariable($name, $value)
    {
        $this->registerJs('window[' . Json::encode(Yii::$app->name) . '][' . Json::encode($name) . '] = ' . $value . ';', View::POS_END);
    }
}
