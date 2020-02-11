<?php


namespace MassUploader\Utilites;


class JsonConfigs
{
    public static function read(string $file)
    {
        if (file_exists( $file ) ) {
            try {
                $content = file_get_contents($file);
                $data = json_decode($content);
                if ($data == null || !is_object($data)) {
                    throw new \Exception('Ошибка декодирования Json: '.json_last_error());
                } else {
                    return $data;
                }
            } catch(\Exception $err) {
                throw new\Exception($err->getMessage());
            }
        } else {
            throw new \Exception('Файл '.$file.' не существует');
        }
    }

    public static function save(string $file, array $configs)
    {
        if (file_exists( $file ) ) {
            try {
                $json = json_encode($configs, JSON_PRETTY_PRINT);
                if (
                    ($file = fopen($file, 'w')) &&
                    (fwrite($file, $json)) &&
                    (fclose($file))
                ) {
                    return true;
                } else {
                    throw new\Exception('Ошибка записи в файл '.$file);
                }
            } catch(\Exception $err) {
                throw new\Exception($err->getMessage());
            }
        } else {
            throw new \Exception('Файл '.$file.' не существует');
        }
    }
}