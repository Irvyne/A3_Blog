<?php
/**
 * Created by Thibaud BARDIN (Irvyne)
 * This code is under the MIT License (https://github.com/Irvyne/license/blob/master/MIT.md)
 */

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $role;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $name
     * @throws Exception
     */
    public function setName($name)
    {
        if (is_string($name))
            $this->name = $name;
        else
            throw new Exception('$name must be a string!');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $password
     * @throws Exception
     */
    public function setPassword($password)
    {
        if (is_string($password))
            $this->password = $password;
        else
            throw new Exception('$password must be a string!');
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $role
     * @throws Exception
     */
    public function setRole($role)
    {
        if (is_string($role))
            $this->role = $role;
        else
            throw new Exception('$role must be a string!');
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
} 