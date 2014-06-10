<?php

namespace app\modules\main\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class AdminController extends Controller
{
    public function getMenu() {}
    
    public function beforeAction($action) 
    {
        if (in_array($action->id, ['imageUpload', 'fileUpload'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [['allow' => \Yii::$app->user->isAdmin()]],
            ],
        ];
    }
    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'fileUpload'    => [
                'class'         => 'app\modules\main\actions\FileUpload',
                'uploadPath'    => \Yii::$app->basePath . '/web/files',
                'uploadUrl'     => '/files'
            ],
            'imageUpload'    => [
                'class'         => 'app\modules\main\actions\ImageUpload',
                'uploadPath'    => \Yii::$app->basePath . '/web/files',
                'uploadUrl'     => '/files'
            ],
            'imageList'    => [
                'class'         => 'app\modules\main\actions\ImageList',
                'uploadPath'    => \Yii::$app->basePath . '/web/files',
                'uploadUrl'     => '/files'
            ],
        ];
    }
    
    public function getModel($id = false, $modelName = false, $attributes = array())
    {
        if ($modelName == false) {
            $modelName = $this->modelName;
        }
        $model = (is_numeric($id))
            ? $modelName::findOne($id)
            : new $modelName();
        if (!$model) {
            throw new CHttpException(404, "Page not found");
        }
        foreach ($attributes as $attribute => $value) {
            $model->$attribute = $value;
        }
        return $model;
    }
	
    public function getModelName()
    {
        return str_replace(
            ['controllers', 'Controller'], 
            ['models', ''], 
            get_called_class()
        );
    }
}