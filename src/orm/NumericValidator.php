<?php


namespace MjLiang\PhpCodingTask\orm;



trait NumericValidator
{

    public function __call($name, $arguments)
    {
        $action = substr($name, 0, 3);

        switch ($action) {
            case 'set':
                $property = lcfirst(substr($name, 3));
                if(property_exists($this,$property)) {

                    $value = $arguments[0];

                    $reflector = new \ReflectionObject($this);
                    $reflectionProperty = $reflector->getProperty($property);

                    $comment = $reflectionProperty->getDocComment();
                    if($comment) {
                        if (preg_match('/@var\s+([^\s]+)/', $comment, $matches)) {
                            list(, $type) = $matches;
                            switch ($type) {
                                case 'int':
                                case 'integer':
                                    if(!is_numeric($value)) {
                                        throw new \Exception('Not a number!');
                                    }
                            }
                        }
                    }
                }

                break;
            default :
                break;
        }

        return parent::__call($name, $arguments);
    }
}
