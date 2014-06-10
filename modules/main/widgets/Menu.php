<?php

namespace app\modules\main\widgets;
use Yii;

class Menu extends \yii\bootstrap\Nav
{
    public $excludedModules = ['main', 'gii', 'debug'];
    
    public function init() 
    {
        parent::init();
        $this->setItems();
    }
    
    private function setItems()
    {
        $items = array_merge($this->adminItems(), $this->userItems());
        $this->items = array_merge($this->items, $items);
    }
    
    private function adminItems()
    {
        $result = [];
        if (!Yii::$app->user->isAdmin()) {
            return $result;
        }

        foreach (\Yii::$app->modules as $name => $module) {
            if (in_array($name, $this->excludedModules)) {
                continue;
            }
            $params = is_object($module) ? $module->params : (isset($module['params']) ? $module['params'] : []);
            $result[] = isset($params['menu'])
                ? $params['menu']
                : ['label'    => ucfirst($name).'s', 'url' => ['/'.$name.'/'.$name.'/index']];
        }
        return $result;
    }
    
    private function userItems()
    {
        if (Yii::$app->user->isGuest) {
            return [['label'    => 'Login', 'url' => ['/user/default/login']]];
        }
        $result = [];
        if (!Yii::$app->user->isAdmin()) {
            $result[] =  ['label' => 'Blacklists', 'url' => ['/blacklist/default/index']];
        }
        $result[] = [
            'label'    => Yii::$app->user->identity->username,
            'items' => [
                ['label'    => 'Profile', 'url' => ['/user/default/update']],
                ['label'    => 'Logout', 'url' => ['/user/default/logout']]
            ]
        ];
        return $result;
    }
}
