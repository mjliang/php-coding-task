<?php

namespace MjLiang\PhpCodingTask\orm;


/**
 * ActiveRecord
 *
 * Abstract class that all child datbase models inherit from.
 *
 * Assume that this class contains boiler plate functionality for handling
 * database reads and writes and that the `save` method is fully implemented.
 */
abstract class ActiveRecord implements ActiveRecordInterface
{

    protected $isModified = false;


    /**
     * Saves a models data to the database
     *
     * @return void
     */
    public function save(): void
    {
        // Assume a full working implementation
    }


    public static function create()
    {
        $model = get_called_class();
        return new $model;
    }

    /**
     * @return bool
     */
    public function isModified() : bool {
        return (bool) $this->isModified;
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this|bool|mixed
     * @throws \ReflectionException
     */
    public function __call($name, $arguments) {

        $action = substr($name, 0, 3);

        switch ($action) {
            case 'get':
            case 'set':
                $property = lcfirst(substr($name, 3));
                if(property_exists($this,$property)) {

                    $reflector = new \ReflectionObject($this);
                    $reflectionProperty = $reflector->getProperty($property);
                    $reflectionProperty->setAccessible(true);

                    $value = $reflectionProperty->getValue($this);

                    if($action == 'set') {
                        $reflectionProperty->setValue($this, $arguments[0]);

                        if($arguments[0] == $value) {
                            $this->isModified = false;
                        } else {
                            $this->isModified = true;
                        }
                        return $this;
                    } else {
                        return $value;
                    }
                }

                break;
            default :
                return FALSE;
        }
    }

}
