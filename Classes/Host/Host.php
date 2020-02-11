<?php


namespace MassUploader\Hosts;

use \MassUploader\Utilites\JsonConfigs;
use \MassUploader\Utilites\Tools;

abstract class Host
{
    private $name;
    private $configs;
    protected $object_type = 'Object';

    public function __construct(string $name)
    {
        if (Utilites::checkAreaImplements('SendForm', $this)) {
            if (!PHP_SAPI === 'cli') {
                throw new \Exception('Запуск этой программы возможен только из командной строки.');
            }
        }

        $this->name = $name;

        $this->getConfigs();
    }

    public static function getByName(string $name)
    {
        $host = new Host($name);
        return $host;
    }

    protected function getConfigs()
    {
        try {
            $conf_filename = ROOT.'configs/host/'.$this->name;
            $this->configs = JsonConfigs::read($conf_filename);
        } catch(\Exception $err) {
            throw new \Exception('Не удалось получить конфиги:' . $err->getMessage());
        }
    }
}