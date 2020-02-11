<?php


namespace MassUploader\Object;


class Video extends Object
{
    protected function getListFromFileStructure($dir)
    {
        if (!is_dir($dir)) {
            throw new \Exception('Недопустимый формат файла');
        }


    }
}