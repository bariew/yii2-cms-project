<?php
namespace app\config;

use yii\base\Exception;

/**
 * Created by PhpStorm.
 * User: pt
 * Date: 27.11.14
 * Time: 12:02
 */

class ConfigManager extends \yii\base\Model
{
    protected static $mainConfigPath = '@app/config/web.php';
    protected static $localConfigPath = '@app/config/local/main.php';

    public $mainConfig;
    public $localConfig;

    public function init()
    {
        parent::init();
        $this->mainConfig = require \Yii::getAlias(self::$mainConfigPath);
        $localPath = \Yii::getAlias(self::$localConfigPath);
        $this->localConfig = file_exists($localPath) ? require $localPath : [];
    }

    public function put($data)
    {
        if ($errorKeys = array_diff_key($data, $this->mainConfig)) {
            throw new Exception("Wrong config keys: " . implode(', ', $errorKeys));
        }
        $this->localConfig = array_merge($this->localConfig, $data);
        return $this->save();
    }

    public function save()
    {
        $content = '<?php return '. var_export($this->localConfig, true) . ';';
        return file_put_contents(\Yii::getAlias(self::$localConfigPath), $content);
    }
} 