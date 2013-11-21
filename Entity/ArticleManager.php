<?php
/**
 * Created by Thibaud BARDIN (Irvyne)
 * This code is under the MIT License (https://github.com/Irvyne/license/blob/master/MIT.md)
 */

class ArticleManager extends BaseManager
{
    const ENTITY    = 'Article';
    const TABLE     = 'article';

    /**
     * @param PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);
    }

    /**
     * @param Article $article
     * @return bool
     */
    public function add(\Article $article)
    {
        $sql = 'INSERT INTO '.self::TABLE.' (id, title, content, author, date, enabled) VALUES (:id, :title, :content, :author, :date, :enabled)';
        $prepare = $this->pdo->prepare($sql);
        $query = $prepare->execute(array(
            ':id'           => null,
            ':title'        => $article->getTitle(),
            ':content'      => $article->getContent(),
            ':author'       => $article->getAuthor(),
            ':date'         => $article->getDate()->format(\DateTimeFormat::MYSQL_DATETIME),
            ':enabled'      => $article->getEnabled(),
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
        $articles = array();
        foreach ($result as $article) {
            $articles[] = new Article($article);
        }
        return $articles;
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
            $articles = array();
            foreach ($result as $article) {
                $articles[] = new Article($article);
            }
            return $articles;
        } else
            return false;
    }

    /**
     * @param $attribute
     * @param $value
     * @return Article|bool
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
            return new Article($result);
        } else
            return true;
    }

    /**
     * @param $id
     * @return Article
     */
    public function find($id)
    {
        $sql = 'SELECT * FROM '.self::TABLE.' WHERE id = '.$this->pdo->quote($id, \PDO::PARAM_INT);
        $query = $this->pdo->query($sql);
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        return new Article($result);
    }

    /**
     * @param Article $article
     * @return bool
     */
    public function update(\Article $article)
    {
        $sql = 'UPDATE '.self::TABLE.' SET  title = :title, content = :content, author = :author, date = :date, enabled = :enabled WHERE id = :id';
        $prepare = $this->pdo->prepare($sql);
        $query = $prepare->execute(array(
            ':id'           => $article->getId(),
            ':title'        => $article->getTitle(),
            ':content'      => $article->getContent(),
            ':author'       => $article->getAuthor(),
            ':date'         => $article->getDate()->format(\DateTimeFormat::MYSQL_DATETIME),
            ':enabled'      => $article->getEnabled(),
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
        elseif ($argument instanceof Article)
            $id = $argument->getId();
        else
            throw new Exception('$argument must be of type integer or object');

        $sql = 'DELETE FROM '.self::TABLE.' WHERE id = '.$this->pdo->quote($id, \PDO::PARAM_INT);
        return $this->pdo->exec($sql);
    }
} 