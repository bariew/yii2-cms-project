<?php

namespace app\modules\user\controllers;

use yii\web\Controller;
use app\modules\user\models\User;
use Yii;

class DefaultController extends Controller
{
    public $modelClass = 'User';
    
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new \app\modules\user\models\LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionRegister()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new \app\modules\user\models\RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash("success", "Please check your email and confirm registration.");
            return $this->goHome();
        }
        return $this->render('register', compact('model'));
    }
    
    public function actionConfirm($auth_key)
    {
        if ($user = User::findOne(compact('auth_key'))) {
            Yii::$app->session->setFlash("success", "You have successfuly completed your registration.");
            Yii::$app->user->login($user);
            $user->activate();
        }else{
            Yii::$app->session->setFlash("danger", "Your auth link is invalid.");
        }
        return $this->goHome();
    }
    
    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        if (!$model = Yii::$app->user->identity) {
            Yii::$app->session->setFlash("danger", "You are not logged in.");
            $this->goHome();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash("success", "Changes has been saved.");
            return $this->refresh();
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    /**
     * @example $this->get("http://blacklist.dev/user/default/test") == '{"code":200,"message":"OK"}'
     */
    public function actionTest()
    {
        echo json_encode(['code'=>200, 'message'=>'OK']);
    }
}
