<?php

namespace Domain\Todo;

use Aura\Sql\ExtendedPdo;

class TodoGateway
{
    protected $pdo;
    protected $factory;

    public function __construct(ExtendedPdo $pdo, TodoFactory $factory)
    {
        $this->pdo = $pdo;
        $this->factory = $factory;
    }

    public function fetchOneById($id)
    {
        $row = $this->pdo->fetchOne(
            'SELECT * FROM todo WHERE todoId = :id',
            array('id' => (int) $id)
        );

        if ($row) {
            return $this->factory->newEntity($row);
        }
    }

    public function create(TodoEntity $entity)
    {
        $affected = $this->pdo->perform(
            'INSERT INTO todo (
                userId,
                description
            ) VALUES (
                :userId,
                :description
            )',
            $entity->getData()
        );

        if ($affected) {
            $entity->id = $this->pdo->lastInsertId();
        }

        return (bool) $affected;
    }

    public function update(TodoEntity $entity)
    {
        $affected = $this->pdo->perform(
            'UPDATE todo
            SET
                userId = :userId,
                description = :description
            WHERE todoId = :todoId',
            $entity->getData()
        );
        return (bool) $affected;
    }

    public function delete(TodoEntity $entity)
    {
        $affected = $this->pdo->perform(
            'DELETE FROM todo WHERE todoId = :todoId',
            array('todoId' => $entity->todoId())
        );
        return (bool) $affected;
    }

    public function hasTodoWithDescription($description) 
    {
        $rows = $this->pdo->fetchOne(
            'SELECT * FROM todo WHERE description = :description',
            array('description' => (string) $description)
        );
        if ($rows) {
            return true;
        }
        return false;
    }

    public function todoWithDescription($description) 
    {
        $rows = $this->pdo->fetchOne(
            'SELECT * FROM todo WHERE description = :description',
            array('description' => (string) $description)
        );
        if ($rows) {
            return $this->factory->newCollection($rows);
        }
        return null;
    }

    public function fetchListFor($userId) 
    {        
        $rows = $this->pdo->fetchAll(
            'SELECT * FROM todo WHERE userId = :userId',
            array('userId' => (int) $userId)
        );
        if ($rows) {
            return $this->factory->newCollection($rows);
        }
        return null;
    }

    // @TODO: 
    public function firstTodoForUserId($userId) { }
}
