<?php
/**
 * ConsoleController class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace app\controllers;

use yii\console\Controller;

/**
 * Runs app console commands.
 *
 * Usage: call it from console: ./yii console/<action>
 * @example ./yii console/cron-hourly
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 */
class ConsoleController extends Controller
{
    /**
     * Runs hourly cron jobs
     * @example echo "0 * * * * /var/www/campman/yii console/cron-hourly" | crontab -e
     */
    public function actionCronHourly()
    {
        switch (date('H')) {
            default: echo "Nothing to run\n";
        }
        echo "Done!\n";
    }

    /**
     * Creates db backup on deploy
     */
    public function actionBackup()
    {
        $user = \Yii::$app->db->username;
        $pass = \Yii::$app->db->password;
        $db = preg_replace('/^.*\=(\w+)$/', '$1', \Yii::$app->db->dsn);
        $name = date('Y-m-d_H-i').".sql";
        $tables = implode(" ", array_filter(\Yii::$app->db->schema->tableNames, function($v){
            return !preg_match('/^data_.*$/', $v);
        }));
        exec("mysqldump -u$user -p$pass $db $tables > " . \Yii::getAlias("@app/runtime/$name"));
    }

    /**
     * Generates data from fixtures ! removes old table data.
     * @throws \yii\db\Exception
     */
    public function actionGenerate()
    {
        \bariew\yii2Tools\tests\FixtureManager::init();
    }
}