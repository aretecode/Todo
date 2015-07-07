<?php

namespace Domain\Common;

trait DataGeneratedTrait {

    public function __construct($data = array())
    {
        $this->setData($data);
    }

    public function setData($data = array())
    {            
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    // @TODO: PASS IN A WHITE OR BLACKLIST? as Param?
    public function getData()
    {
        $properties = get_object_vars($this);
        return $properties;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
}