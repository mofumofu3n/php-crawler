<?php
namespace Mofumofu3n\Crawelr\Parser;

use Mofumofu3n\Crawelr\Model\StructArticle;

class RdfParser extends BaseParser
{
    public function parse($rssData)
    {
        $articles = array();
        foreach ($rssData->item as $item) {
            array_push($articles, $this->parseArticle($item));
        }

        return $articles;
    }


    protected function parseArticle($entry)
    {
        $article[StructArticle::ARTICLE_TITLE] = (string)$entry->title;
        $article[StructArticle::ARTICLE_LINK] = (string)$entry->link;
        $article[StructArticle::ARTICLE_IMAGE] = parent::getOgImage($article[StructArticle::ARTICLE_LINK]);
        $article[StructArticle::ARTICLE_PUBLISHED_DATE] =
            parent::getTimestamp((string)$entry->children('http://purl.org/dc/elements/1.1/')->date);
        $article[StructArticle::ARTICLE_CONTENT] = (string)$entry->description;
        $article[StructArticle::ARTICLE_RSS_ID] = $this->feedId;

        return $article;
    }
}
