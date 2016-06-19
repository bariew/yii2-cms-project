<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\web\themes\null;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@webroot/themes/null';
    public $css = [
        'css/main.css',
    ];
    public $js = [
        'js/main.js'
    ];
    public $depends = [
        'yii\jui\JuiAsset',
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
        'raoul2000\bootswatch\BootswatchAsset',
    ];
}
