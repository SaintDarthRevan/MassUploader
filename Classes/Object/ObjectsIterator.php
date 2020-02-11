<?php


namespace MassUploader\Object;


class ObjectsIterator implements \Iterator
{
    private $list = array();
    private $total = 0;
    private $key = 0;
    private $counter = array();

    public function __construct(array $list)
    {
        $this->list = $list;
        $this->total = count($list);
        foreach($list as $key => $value) {
            $this->counter[$key] = 0;
        }
    }

    public function current()
    {
        return $this->list[$this->key];
    }

    public function key()
    {
        return $this->key;
    }

    public function next(bool $check = false)
    {
        ++$this->key;
        if (!$this->valid())
            $this->rewind();

        if ($check)
            $this->checkOver();
    }

    public function rewind()
    {
        $this->key = 0;
    }

    public function valid()
    {
        return isset($this->list[$this->key]);
    }

    public function get(integer $id)
    {
        if (isset($this->list[$id])) {

            return $this->list[$id];
        } else {
            throw new \Exception('Выбранный файл не существует');
        }
    }

    public function setPos(integer $pos)
    {
        if (isset($this->list[$pos])) {
            $this->key = $pos;
            return true;
        } else {
            throw new \Exception('Выбранный файл не существует');
        }
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getAsArray()
    {
        return $this->list;
    }

    public function checkOver()
    {
        if ($this->total > 1 && $this->valid() && $this->list[$this->key]->configs->over > 0) {
            $this->list[$this->key]->configs->over--;
            $this->list[$this->key]->save();
            $this->key++;

            if (!$this->valid()) {
                $this->rewind();
            }
        }
    }
}