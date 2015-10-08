<?php
/**
 * AllLinkClickTest class file.
 * @copyright (c) 2014, Galament
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

use \bariew\docTest\ClickTest;

/**
 * Example for ClickTest usage.
 *
 * Usage: it is for running with yii2 command "vendor/bin/codecept run acceptance"
 *
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class AllLinkClickTest extends \yii\codeception\TestCase
{
    //public $appConfig = '@tests/codeception/config/backend/functional.php';

    /**
     * Clicks all app links.
     */
    public function testLinks()
    {
        $clickTest = $this->getClickTest();
        $clickTest->clickAllLinks('/index-test.php/');
        $clickTest->result();
    }

    /**
     * Creates click test instance.
     * @return ClickTest click test instance.
     */
    public function getClickTest()
    {
        // init clicktest with required base url param.
        $cookieFile = '/tmp/campmanClickTest';
        @unlink($cookieFile);
        $params = Yii::$app->params;
        $clickTest = new ClickTest($params['baseUrl'], [
            'formOptions' => [],
            'groupUrls' => true,
            'createExcepts' => [
                [['(.*\/)', false],['(\d+)', true]]
            ],
            'curlOptions' => [
                'cookieFile' => $cookieFile,
                'unique' => true,
            ],
            'pageCallback' => [$this, 'checkPage'],
        ]);
        $clickTest->selector = 'a:not([href=""])';
        $clickTest->except = array_merge($clickTest->except, [
            '/log/',
            '/storage/',
        ]);

        // login to your login page with your access data.
        $clickTest
            ->request('/index-test.php/user/default/logout')
            ->login('/index-test.php/user/default/login', [
            'LoginForm[username]' => $params['auth']['username'],
            'LoginForm[password]' => $params['auth']['password'],
            // click all site links recursively starting from root '/' url.
        ]);
        return $clickTest;
    }

    public function checkPage($url, $content, $errors)
    {
        if (preg_match('/\<title\>\s*\<\/title\>/', $content)) {
            $errors[$url] = "Missing title";
        }
    }

    public function getName($withDataSet = TRUE)
    {
        return 'testLinks';
    }

    public function toString()
    {
        // TODO: Implement toString() method.
    }
}