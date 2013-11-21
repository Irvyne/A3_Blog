<?php
/**
 * Created by Thibaud BARDIN (Irvyne)
 * This code is under the MIT License (https://github.com/Irvyne/license/blob/master/MIT.md)
 */

class Article extends BaseHydrate
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $author;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var boolean
     */
    private $enabled;

    /**
     * @param array $data
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
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
     * @param \DateTime|string $argument
     */
    public function setDate($argument)
    {
        if ($argument instanceof \DateTime)
            $this->date = $argument;
        else
            $this->date = new DateTime($argument);
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param boolean|int|string $enabled
     * @throws Exception
     */
    public function setEnabled($enabled)
    {
        if (is_bool($enabled))
            $this->enabled = $enabled;
        elseif (is_int($enabled) || is_string($enabled))
            $this->enabled = (bool) $enabled;
        else
            throw new Exception('$enabled must be a boolean, an integer or a string!');
    }

    /**
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

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
     * @param $title
     * @throws Exception
     */
    public function setTitle($title)
    {
        if (is_string($title))
            $this->title = $title;
        else
            throw new Exception('$title must be a string!');
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
} 