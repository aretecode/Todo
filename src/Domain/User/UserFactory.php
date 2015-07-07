<?php

// @26/06/15-19:05
// @26/06/15-11:20
namespace Domain\User;

class UserFactory
{
    public function newEntity($row)
    {
        return new UserEntity($row);
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
