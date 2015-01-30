<?php
namespace Mofumofu3n\Crawler\Model;

/**
 * Class Article
 * @package Mofumofu3n\Crawler\Model
 */
class Article
{
    /**
     * 記事タイトル
     * @var string
     */
    protected $title;

    /**
     * 記事URL
     * @var string
     */
    protected $link;

    /**
     * FeedのURL
     * @var string
     */
    protected $feedLink;

    /**
     * 記事の入稿時間
     * @var int
     */
    protected $publishedDate;

    /**
     * 記事の要約
     * @var string
     */
    protected $content;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getFeedLink()
    {
        return $this->feedLink;
    }

    /**
     * @param string $feedLink
     */
    public function setFeedLink($feedLink)
    {
        $this->feedLink = $feedLink;
    }

    /**
     * @return int
     */
    public function getPublishedDate()
    {
        return $this->publishedDate;
    }

    /**
     * @param int $publishedDate
     */
    public function setPublishedDate($publishedDate)
    {
        $this->publishedDate = $publishedDate;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }


}