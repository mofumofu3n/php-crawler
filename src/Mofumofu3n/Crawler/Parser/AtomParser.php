<?php
namespace Mofumofu3n\Crawler\Parser;

use Mofumofu3n\Crawler\Model\StructArticle;

class AtomParser extends BaseParser
{
    public function parse($rssData)
    {
        $articles = array();
        foreach ($rssData->entry as $entry) {
            array_push($articles, $this->parseArticle($entry));
        }
        return $articles;
    }

    public function parseArticle($entry)
    {
        $article[StructArticle::ARTICLE_TITLE] = (string) $entry->title;
        $article[StructArticle::ARTICLE_LINK] = (string) $entry->link->attributes()->href;
        $article[StructArticle::ARTICLE_IMAGE] = parent::getOgImage($article[StructArticle::ARTICLE_LINK]);
        $article[StructArticle::ARTICLE_PUBLISHED_DATE] = parent::getTimestamp((string)$entry->issued);

        $article[StructArticle::ARTICLE_CONTENT] = (string) $entry->content;
        $article[StructArticle::ARTICLE_RSS_ID] = $this->feedId;

        return $article;
    }
}
