<?php
/**
 * Created by Thibaud BARDIN (Irvyne)
 * This code is under the MIT License (https://github.com/Irvyne/license/blob/master/MIT.md)
 */

class CommentManager extends BaseManager
{
    const ENTITY    = 'Comment';
    const TABLE     = 'comment';

    /**
     * @param PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);
    }

    /**
     * @param Comment $comment
     * @return bool
     */
    public function add(\Comment $comment)
    {
        $sql = 'INSERT INTO '.self::TABLE.' (id, content, author, article) VALUES (:id, :content, :author, :article)';
        $prepare = $this->pdo->prepare($sql);
        $query = $prepare->execute(array(
            ':id'       => null,
            ':content'  => $comment->getContent(),
            ':author'   => $comment->getAuthor(),
            ':article'  => $comment->getArticle(),
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
        $comments = array();
        foreach ($result as $comment) {
            $comments[] = new Comment($comment);
        }
        return $comments;
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
            $comments = array();
            foreach ($result as $comment) {
                $comments[] = new Comment($comment);
            }
            return $comments;
        } else
            return false;
    }

    /**
     * @param $attribute
     * @param $value
     * @return bool|Comment
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
            return new Comment($result);
        } else
            return true;
    }

    /**
     * @param $id
     * @return Comment
     */
    public function find($id)
    {
        $sql = 'SELECT * FROM '.self::TABLE.' WHERE id = '.$this->pdo->quote($id, \PDO::PARAM_INT);
        $query = $this->pdo->query($sql);
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        return new Comment($result);
    }

    /**
     * @param Comment $comment
     * @return bool
     */
    public function update(\Comment $comment)
    {
        $sql = 'UPDATE '.self::TABLE.' SET  content = :content, author = :author, article = :article WHERE id = :id';
        $prepare = $this->pdo->prepare($sql);
        $query = $prepare->execute(array(
            ':id'           => $comment->getId(),
            ':content'      => $comment->getContent(),
            ':author'       => $comment->getAuthor(),
            ':article'      => $comment->getArticle(),
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
        elseif ($argument instanceof Comment)
            $id = $argument->getId();
        else
            throw new Exception('$argument must be of type integer or object');

        $sql = 'DELETE FROM '.self::TABLE.' WHERE id = '.$this->pdo->quote($id, \PDO::PARAM_INT);
        return $this->pdo->exec($sql);
    }
} 