<?php
/**
 * ExampleClickTest class file.
 * @copyright (c) 2014, Galament
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

use \bariew\docTest\ClickTest;

/**
 * Example for ClickTest usage.
 *
 * Usage: it is for running with yii2 command "vendor/bin/codecept run unit"
 *
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class ExampleClickTest extends \yii\codeception\TestCase
{

    public function testLinks()
    {
        // init clicktest with required base url param.
        $clickTest = new ClickTest('http://cms.dev');
        // login to your login page with your access data.
        $clickTest->request(
            '/user/default/logout'
        )->login('/user/default/login', [
            'LoginForm[username]'=>'pt',
            'LoginForm[password]'=>'pt'
        // click all site links recursively starting from root '/' url.
        ])->clickAllLinks('/');
        // display result.
        $clickTest->result();
    }
}