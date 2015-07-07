<?php

namespace Domain\Todo;

class TodoFilter
{
    protected $messages = array();
    protected $todo;

    public function getMessages()
    {
        return $this->messages;
    }

    public function forInsert(TodoEntity $todo)
    {
        $this->todo = $todo;
        $this->messages = array();
        return $this->basic($todo);
    }

    public function forUpdate(TodoEntity $todo)
    {
        $this->todo = $todo;
        $this->messages = array();

        $this->todo->setTodoId(trim($this->todo->todoId()));
        if (! $this->todo->todoId()) {
            $this->messages['id'] = 'id cannot be empty.';
        }

        return $this->basic($todo);
    }

    protected function basic($todo = null)
    {
        $this->todo->setTodoId(trim($this->todo->todoId()));
        if (! $this->todo->todoId()) {
            $this->messages['id'] = 'id cannot be empty.';
        }

        $this->todo->changeDescription(trim($this->todo->description()));
        if (! $this->todo->description()) {
            $this->messages['description'] = 'Description cannot be empty.';
        }

        $this->todo->setUserId(trim($this->todo->userId()));
        if (! $this->todo->userId()) {
            $this->messages['userId'] = 'UserId cannot be empty.';
        }

        return $this->isValid();
    }

    protected function isValid()
    {
        if ($this->messages) {
            return false;
        }

        return true;
    }
}