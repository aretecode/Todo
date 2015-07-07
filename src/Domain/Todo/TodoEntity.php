<?php

namespace Domain\Todo;

use JsonSerializable;
use Domain\Common\UserIdTrait;
use Domain\Common\DataGeneratedTrait;

class TodoEntity implements JsonSerializable {
    use UserIdTrait;
    use DataGeneratedTrait;

    /** 
     * @var string 
     */
    protected $description;

    /**
     * @var mixed(UUID, String, Int, TodoId)
     */
    protected $todoId;

    /**
     * @see $this->todoId 
     */
    public function todoId() {
        return $this->todoId;
    }

    /**
     * or changeTodoId
     * @param $todoId
     */
    public function setTodoId($todoId) {
        $this->todoId = $todoId;
    }

    /**
     * @return string $description the description of this Todo
     */
    public function description() {
        return $this->description;
    }

    /**
     * @param string $description the description of this Todo
     */
    public function changeDescription($description) {
        $this->description = $description; // Event?
    }
}