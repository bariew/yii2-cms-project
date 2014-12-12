<?php
/**
 * ConfigManager class file.
 * @copyright (c) 2014, Bariew
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace app\config;

/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 */

class ConfigManager
{
    /**
     * @var string path to write content to.
     */
    private static $writePath = '@app/config/local/main.php';

    /**
     * @var mixed file data.
     */
    public static $data;

    /**
     * Setting model options. Read path is required.
     */
    public static function getData()
    {
        return (self::$data === null)
            ? self::$data = require \Yii::getAlias('@app/config/web.php')
            : self::$data;
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
        $config = self::getData();
        if (!$key) {
            $config = array_merge($config, $value);
        }
        $key = is_array($key) ? $key : [$key];

        $data = &$config;
        while ($key) {
            $k = array_shift($key);
            $config[$k] = isset($config[$k]) ? $config[$k] : [];
            $config[$k] = $key
                ? $config[$k]
                : (is_array($value)
                    ? array_merge($config[$k], $value)
                    : $value);
            $config = &$config[$k];
        }
        self::$data = $data;
        return self::save();
    }

    /**
     * Gets data sub value.
     * @see \self::set() For multidimensional
     * @param $key
     * @return array|mixed
     */
    public static function get($key)
    {
        $key = is_array($key) ? $key : [$key];
        $config = self::getData();
        while ($key) {
            $k = array_shift($key);
            $config = isset($config[$k]) ? $config[$k] : [];
        }
        return $config;
    }

    /**
     * Removes key from data.
     * @see \self::set() For multidimensional
     * @param $key
     * @return int
     */
    public static function remove($key)
    {
        $key = is_array($key) ? $key : [$key];
        $config = self::getData();
        $data = &$config;
        while ($key) {
            $k = array_shift($key);
            if (!$key) {
                unset($config[$k]);
                break;
            }
            $config[$k] = isset($config[$k]) ? $config[$k] : [];
            $config = &$config[$k];
        }
        self::$data = $data;
        return self::save();
    }

    /**
     * Puts complete data into file.
     * @param $data
     * @return int
     * @throws \Exception
     */
    public static function put($data)
    {
        if ($errorKeys = array_diff_key($data, self::getData())) {
            throw new \Exception("Wrong config keys: " . implode(', ', $errorKeys));
        }
        self::$data = array_merge(self::getData(), $data);
        return self::save();
    }

    /**
     * Saves self::getData() to file.
     * @return int
     */
    public static function save()
    {
        $content = '<?php return '. var_export(self::getData(), true) . ';';
        apc_clear_cache();
        opcache_reset();
        return file_put_contents(\Yii::getAlias(self::$writePath), $content);
    }
} 