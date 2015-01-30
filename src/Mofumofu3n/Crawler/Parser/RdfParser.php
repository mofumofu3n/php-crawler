<?php
namespace Mofumofu3n\Crawler\Parser;

use Mofumofu3n\Crawler\Model\Article;

class RdfParser extends BaseParser
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
        foreach ($rssData->item as $item) {
            array_push($articles, $this->parseArticle($item));
        }
        return $articles;
    }

    /**
     * parseArticle
     *
     * @param \SimpleXMLElement $entry
     * @access public
     * @return Article
     */
    protected function parseArticle($entry)
    {
        $article = new Article();
        $article->setTitle((string)$entry->title);
        $article->setLink((string)$entry->link);
        $article->setFeedLink($this->feedUrl);
        $article->setPublishedDate(parent::getTimestamp((string)$entry->children('http://purl.org/dc/elements/1.1/')->date));
        $article->setContent((string)$entry->description);
        return $article;
    }
}
