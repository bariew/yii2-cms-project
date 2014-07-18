<?php
class ControllerTest extends \yii\codeception\TestCase
{
    public function testSite()
    {
         $docTester = new \bariew\docTest\UrlTest('app\controllers\SiteController');
         $docTester->test();
    }
}