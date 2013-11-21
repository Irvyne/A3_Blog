<?php
/**
 * Created by Thibaud BARDIN (Irvyne)
 * This code is under the MIT License (https://github.com/Irvyne/license/blob/master/MIT.md)
 */

abstract class BaseManager
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function getEntity()
    {
        $reflectionObject = new ReflectionObject($this);
        $className = $reflectionObject->getName();
        return $className::ENTITY;
        /*
         * $this::ENTITY
         */
    }
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws InvalidArgumentException
     * @throws BadMethodCallException
     */
    public function __call($name, $arguments)
    {
        switch (true):
            case (0 === strpos($name, 'findAllBy')):
                $by = substr($name, 9);
                $method = 'findAllBy';
                break;
            case (0 === strpos($name, 'findOneBy')):
                $by = substr($name, 9);
                $method = 'findOneBy';
                break;
            default:
                throw new BadMethodCallException(sprintf(
                    'Undefined method %s. The method name must start with either findAllBy or findOneBy!',
                    $name
                ));
        endswitch;

        $by = lcfirst($by);
        $entity = $this->getEntity();

        if (property_exists(new $entity, $by)) {
            return $this->$method($by, $arguments[0]);
        } else {
            throw new InvalidArgumentException(sprintf(
                'Property %s doesn\'t exist in class Article',
                $by
            ));
        }
    }
} 