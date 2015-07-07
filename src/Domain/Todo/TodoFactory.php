<?php

namespace Domain\Todo;

class TodoFactory
{
    public function newEntity($row)
    {
        return new TodoEntity($row);
    }

    public function newCollection($rows)
    {
        $collection = array();
        foreach ($rows as $row) {
            $collection[] = $this->newEntity($row);
        }
        return $collection;
    }
}
