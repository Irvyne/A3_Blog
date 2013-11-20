<?php
/**
 * Created by Thibaud BARDIN (Irvyne)
 * This code is under the MIT License (https://github.com/Irvyne/license/blob/master/MIT.md)
 */

abstract class BaseHydrate
{
    public function __construct(array $data = null)
    {
        if (null !== $data)
            $this->hydrate($data);
    }

    protected function hydrate(array $data)
    {
        foreach($data as $attribute => $value) {
            $method = 'set'.ucfirst($attribute);
            if (method_exists($this, $method))
                $this->$method($value);
            else
                throw new LogicException(sprintf(
                    'Method %s with value %s doesn\'t exist',
                    $method, $value
                ));
        }
    }
} 