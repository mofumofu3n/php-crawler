<?php
namespace Mofumofu3n\Crawler\Parser;

use Mofumofu3n\Crawler\Model\Article;

class RssParser extends BaseParser
{
    /**
     * parse
     *
     * @param mixed $rssData
     * @access protected
     * @return array
     */
    public function parse($rssData)
    {
        $articles = array();
        foreach ($rssData->channel->item as $entry) {
            array_push($articles, $this->parseArticle($entry));
        }

        return $articles;
    }

    /**
     * @param \SimpleXMLElement $entry
     * @return Article
     */
    public function parseArticle($entry)
    {
        $article = new Article();
        $article->setTitle((string)$entry->title);
        $article->setLink((string)$entry->link);
        $article->setFeedLink($this->feedUrl);
        $article->setPublishedDate(parent::getTimestamp((string)$entry->pubDate));
        $article->setContent((string)$entry->description);
        return $article;
    }
}
