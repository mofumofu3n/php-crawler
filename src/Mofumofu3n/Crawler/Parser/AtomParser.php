<?php
namespace Mofumofu3n\Crawler\Parser;

use Mofumofu3n\Crawler\Model\Article;

class AtomParser extends BaseParser
{
    /**
     * parse
     *
     * @param mixed $rssData
     * @return array
     */
    public function parse($rssData)
    {
        $articles = array();
        foreach ($rssData->entry as $entry) {
            array_push($articles, $this->parseArticle($entry));
        }
        return $articles;
    }

    /**
     * parseArticle
     * @param \SimpleXMLElement $entry
     * @return Article
     */
    protected function parseArticle($entry)
    {
        $article = new Article();
        $article->setTitle((string)$entry->title);
        $article->setLink((string)$entry->link->attributes()->href);
        $article->setFeedLink($this->feedUrl);
        $article->setPublishedDate(parent::getTimestamp((string)$entry->issued));
        $article->setContent((string)$entry->content);
        return $article;
    }
}
