<?php

namespace app\modules\main\controllers;

use yii\console\Controller,
    Behat\Mink\Mink,
    Behat\Mink\Session,
    Behat\Mink\Driver\WUnitDriver;

class TestController extends Controller
{

    
    public function actionView()
    {
        $mink = new Mink(array(
            'wunit' => new Session(new WUnitDriver()),
        ));
        $mink->getSession('wunit')->visit('http://cms.dev')->getPage()->findLink('Chat')->click();
    }
}