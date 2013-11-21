<?php
/**
 * Created by Thibaud BARDIN (Irvyne)
 * This code is under the MIT License (https://github.com/Irvyne/license/blob/master/MIT.md)
 */

class UserManager
{
    /**
     * @var \PDO
     */
    private $pdo;

    const TABLE = 'user';

    /**
     * @param PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function add(\User $user)
    {
        $sql = 'INSERT INTO '.self::TABLE.' (id, name, password, role) VALUES (:id, :name, :password, :role)';
        $prepare = $this->pdo->prepare($sql);
        $query = $prepare->execute(array(
            ':id'       => null,
            ':name'     => $user->getName(),
            ':password' => self::hashPassword($user->getPassword()),
            ':role'     => $user->getRole(),
        ));
        return $query;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $sql = 'SELECT * FROM '.self::TABLE;
        $query = $this->pdo->query($sql);
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);
        $users = array();
        foreach ($result as $user) {
            $users[] = new User($user);
        }
        return $users;
    }

    /**
     * @param $attribute
     * @param $value
     * @return array|bool
     */
    protected function findAllBy($attribute, $value)
    {
        $sql = 'SELECT * FROM '.self::TABLE.' WHERE '.$attribute.' = :value';
        $prepare = $this->pdo->prepare($sql);
        $query = $prepare->execute(array(
            ':value'        => $value,
        ));
        if ($query) {
            $result = $prepare->fetchAll(\PDO::FETCH_ASSOC);
            $users = array();
            foreach ($result as $user) {
                $users[] = new User($user);
            }
            return $users;
        } else
            return false;
    }

    /**
     * @param $attribute
     * @param $value
     * @return bool|User
     */
    protected function findOneBy($attribute, $value)
    {
        $sql = 'SELECT * FROM '.self::TABLE.' WHERE '.$attribute.' = :value';
        $prepare = $this->pdo->prepare($sql);
        $query = $prepare->execute(array(
            ':value' => $value,
        ));
        if ($query) {
            $result = $prepare->fetch(\PDO::FETCH_ASSOC);
            return new User($result);
        } else
            return true;
    }

    /**
     * @param $id
     * @return User
     */
    public function find($id)
    {
        $sql = 'SELECT * FROM '.self::TABLE.' WHERE id = '.$this->pdo->quote($id, \PDO::PARAM_INT);
        $query = $this->pdo->query($sql);
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        return new User($result);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function update(\User $user)
    {
        $sql = 'UPDATE '.self::TABLE.' SET  name = :name, password = :password, role = :role WHERE id = :id';
        $prepare = $this->pdo->prepare($sql);
        $query = $prepare->execute(array(
            ':id'       => $user->getId(),
            ':name'     => $user->getName(),
            ':password' => self::hashPassword($user->getPassword()),
            ':role'     => $user->getRole(),
        ));
        return $query;
    }

    /**
     * @param $argument
     * @return int
     * @throws Exception
     */
    public function delete($argument)
    {
        if (is_int($argument))
            $id = $argument;
        elseif ($argument instanceof User)
            $id = $argument->getId();
        else
            throw new Exception('$argument must be of type integer or object');

        $sql = 'DELETE FROM '.self::TABLE.' WHERE id = '.$this->pdo->quote($id, \PDO::PARAM_INT);
        return $this->pdo->exec($sql);
    }

    /**
     * @param $password
     * @return string
     */
    protected static function hashPassword($password)
    {
        return sha1($password);
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

        if (property_exists(new User(), $by)) {
            return $this->$method($by, $arguments[0]);
        } else {
            throw new InvalidArgumentException(sprintf(
                'Property %s doesn\'t exist in class User',
                $by
            ));
        }
    }
} 