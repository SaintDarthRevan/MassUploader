<?php


namespace MassUploader\Utilites;

class Tools
{
    const LOGS_DIR = BASEDIR.'logs/';
    public static $area_name = null;

    public static function writeLog(string $text)
    {
        if (static::$area_name) {
            $logFile = static::LOGS_DIR.static::$area_name.'.log';
        } else {
            $logFile = static::LOGS_DIR.'default.log';
        }

        if (!file_exists($logFile)) {
            $file = fopen($logFile, 'w');
        } else {
            $file = fopen($logFile, 'a');
        }

        if (PHP_SAPI === 'cli') {
            $platform = ' console';
        } else {
            $platform = '';
        }

        $str = '['.date('d.m.y H:i:s').$platform.'] '. iconv('UTF-8', 'Windows-1251', $text)."\r\n";

        fwrite($file, $str);
        fclose($file);
    }

    public static function exception_handler($exception)
    {
        static::writeLog($exception->getMessage());

        if (PHP_SAPI === 'cli') {
            http_response_code(500);
        } else {
            echo 'Ошибка: '.$exception->getMessage().'<br /><br />Файл: '.$exception->getFile().'<br />Строка '.$exception->getLine();
        }
    }

    public static function checkImplements(string $interface_name, $object)
    {
        $class = get_class($object);
        $interfaces = class_implements($class);
        if (isset($interfaces[$interface_name])) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkHostImplements(string $interface_name, $object)
    {
        return static::checkImplements("MassUploader\Host\Interfaces\\$interface_name", $object);
    }

    public static function cl($v)
    {
        if (function_exists("dump")) {
            dump($v);
        } else {
            echo "<pre style='background: #ffffff; display: block; clear: both;'>";
            var_dump($v);
            echo "</pre>";
        }
    }
}