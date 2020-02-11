<?php


namespace MassUploader\Object;

use ObjectIterator;

abstract class Object
{
    protected $filepath;
    protected $file_properties = [
        'info' => [
        ],
        'prop' => [
        ]
    ];
    protected $allowed_extensions = [];

    public function __construct(string $filepath)
    {
        $this->filepath = $filepath;

        $this->$file_properties['prop']['ext'] = pathinfo($this->filepath)['extension'];
        $this->$file_properties['prop']['fname'] = pathinfo($this->filepath)['filename'];
        $this->$file_properties['prop']['size'] = filesize($this->filepath);

    }

    public static function create(string $filepath)
    {
        if (!file_exists($filepath)) {
            throw new \Exception('Файл не найден');
        }

        if (!in_array(pathinfo($filepath)['extension'], $this->allowed_extensions)) {
            throw new \Exception('Недопустимый формат файла');
        }

        $classname = get_called_class();
        $object = new $classname($filepath);

        return $object;
    }

    public function getList()
    {

        $list = ;

        return new ObjectIterator(array $list);
    }


}