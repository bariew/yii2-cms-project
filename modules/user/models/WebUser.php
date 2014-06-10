<?php
namespace app\modules\user\models;

class WebUser extends \yii\web\User
{
    public $identityClass = 'app\modules\user\models\User';
    public function level($role)
    {
        if (!$user = $this->identity) {
            return false;
        }
        $roles = array_flip($user->roleList());
        if (!isset($roles[$role])) {
            throw new \yii\web\HttpException(400, 'Undefined role name');
        }
        return $user->level($roles[$role]);
    }
    
    public function isAdmin()
    {
        return $this->level('Admin');
    }
}
