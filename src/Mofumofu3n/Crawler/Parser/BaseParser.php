<?php
namespace Mofumofu3n\Crawler\Parser;

use Mofumofu3n\Crawler\Model\Article;

abstract class BaseParser
{
    /**
     * feedのURL
     * @var string
     */
    protected $feedUrl;

    /**
     * @param mixed $rssData
     * @abstract
     * @access protected
     * @return array
     */
    abstract public function parse($rssData);

    /**
     * @param \SimpleXMLElement $entry
     * @access public
     * @return Article
     */
    abstract protected function parseArticle($entry);

    /**
     * feedのURLをセット
     *
     * @param string $feedUrl
     */
    public function setFeedUrl($feedUrl)
    {
        $this->feedUrl = $feedUrl;
    }

    /**
     * 時刻をUnixTimeに変換する
     *
     * @param $published_date
     * @return int
     */
    protected function getTimestamp($published_date)
    {
        $datetime = new \DateTime($published_date);
        return $datetime->getTimestamp();
    }
}
