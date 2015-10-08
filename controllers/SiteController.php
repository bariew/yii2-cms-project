<?php
/**
 * SiteController class file.
 * @copyright (c) 2014, Bariew
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace app\controllers;

use app\modules\campaign\controllers\DashboardController;
use app\modules\user\models\User;
use Codeception\Module\Yii2;
use yii\web\Controller;

/**
 * Simple base controller.
 *
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class SiteController extends Controller
{
    /**
     * Controller additional actions.
     * @return array available actions.
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Renders index page.
     * @return string view.
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}