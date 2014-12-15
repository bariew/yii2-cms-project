<?php
/**
 * ConfigManager class file.
 * @copyright (c) 2014, Bariew
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace app\config;

use bariew\phptools\FileModel;

/**
 * This class is for reading and writing config file data.
 *
 * @examples:
 * 1. Getting all data: $config = ConfigManager::getData();
 * 2. Changing data: $config['components']['user']['userIdentity'] = 'my/class/Name';
 * 3. Setting all data: ConfigManager::put($config);
 *
 * You can operate with multidimensional arrays in a special way:
 * Removing data by multidimensional key ConfigManager::remove(['components', 'user', 'userIdentity'])
 *  - removes config['components']['user']['userIdentity']
 * Getting data by simple key: ConfigManager::get('modules')
 * Setting data by multidimensional key: ConfigManager::set(['modules', 'user'], 'my/user/Module')
 *
 * @author Pavel Bariev <bariew@yandex.ru>
 */

class ConfigManager
{
    /**
     * @var mixed file data.
     */
    private static $_file;

    /**
     * @return FileModel
     */
    private static function getFile()
    {
        return self::$_file !== null
            ? self::$_file
            : self::$_file = new FileModel(\Yii::getAlias('@app/config/web.php'), [
                'writePath' => \Yii::getAlias('@app/config/local/main.php')
            ]);
    }
    /**
     * Setting model options. Read path is required.
     */
    public static function getData()
    {
        return self::getFile()->data;
    }

    /**
     * Putting data to file.
     * You may put into depth of multidimensional array
     * when your key is array.
     * e.g. self::set(['a', 'b'], 1) will set data to ['a' => ['b' => 1 ... ] ...].
     * @param array|string $key
     * @param mixed $value
     * @return int
     */
    public static function set($key, $value)
    {
        return self::getFile()->set($key, $value);
    }

    /**
     * Gets data sub value.
     * @see \self::set() For multidimensional
     * @param $key
     * @return array|mixed
     */
    public static function get($key)
    {
        return self::getFile()->get($key);
    }

    /**
     * Removes key from data.
     * @see \self::set() For multidimensional
     * @param $key
     * @return int
     */
    public static function remove($key)
    {
        return self::getFile()->remove($key);
    }

    /**
     * Puts complete data into file.
     * @param $data
     * @return int
     * @throws \Exception
     */
    public static function put($data)
    {
        return self::getFile()->put($data);
    }

    /**
     * Saves self::getData() to file.
     * @return int
     */
    public static function save()
    {
        return self::getFile()->save();
    }
} 