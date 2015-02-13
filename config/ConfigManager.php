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
    private static $_files = [];

    /**
     * @return FileModel
     */
    private static function getFile($path)
    {
        if (isset(self::$_files[$path])) {
            return self::$_files[$path];
        }
        if (!file_exists($path)) {
            file_put_contents($path, '<?php return [];');
        }
        return self::$_files[$path] = new FileModel($path);
    }

    private static function getReadFile()
    {
        return self::getFile(\Yii::getAlias('@app/config/web.php'));
    }

    private static function getWriteFile()
    {
        return self::getFile(\Yii::getAlias('@app/config/local/main.php'));
    }

    /**
     * Setting model options. Read path is required.
     */
    public static function getReadData()
    {
        return self::getReadFile()->data;
    }


    /**
     * Setting model options. Read path is required.
     */
    public static function getWriteData()
    {
        return self::getReadFile()->data;
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
        return self::getWriteFile()->set($key, $value);
    }

    /**
     * Gets data sub value.
     * @see \self::set() For multidimensional
     * @param $key
     * @return array|mixed
     */
    public static function get($key)
    {
        return self::getReadFile()->get($key);
    }

    /**
     * Removes key from data.
     * @see \self::set() For multidimensional
     * @param $key
     * @return int
     */
    public static function remove($key)
    {
        return self::getWriteFile()->remove($key);
    }

    /**
     * Puts complete data into file.
     * @param $data
     * @return int
     * @throws \Exception
     */
    public static function put($data)
    {
        return self::getWriteFile()->put($data);
    }

    /**
     * Saves self::getData() to file.
     * @return int
     */
    public static function save()
    {
        return self::getWriteFile()->save();
    }

    /**
     * Finds value in params.
     * @param $key
     * @param $value
     * @return bool
     */
    public static function find($key, $value)
    {
        $data = self::get($key);
        if (!is_array($data)) {
            return $data == $value;
        }
        $result = false;
        array_walk_recursive($data, function ($v) use ($result, $value) {
            if ($v === $value) $result = true;
        });
        return $result;
    }
} 