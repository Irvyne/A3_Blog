<?php
/**
 * Created by Thibaud BARDIN (Irvyne)
 * This code is under the MIT License (https://github.com/Irvyne/license/blob/master/MIT.md)
 */

class Comment extends BaseHydrate
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $author;

    /**
     * @var int
     */
    private $article;

    /**
     * @param array $data
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
    }

    /**
     * @param int $article
     */
    public function setArticle($article)
    {
        $this->article = (int) $article;
    }

    /**
     * @return int
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param int $author
     */
    public function setAuthor($author)
    {
        $this->author = (int) $author;
    }

    /**
     * @return int
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param $content
     * @throws Exception
     */
    public function setContent($content)
    {
        if (is_string($content))
            $this->content = $content;
        else
            throw new Exception('$content must be a string!');
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id =  (int) $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


} 