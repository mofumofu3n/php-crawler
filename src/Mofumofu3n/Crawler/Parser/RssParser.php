<?php
namespace Mofumofu3n\Crawelr\Parser;

use Mofumofu3n\Crawelr\Model\StructArticle;

class RssParser extends BaseParser
{
    public function parse($rssData)
    {
        $articles = array();
        foreach ($rssData->channel->item as $entry) {
            array_push($articles, $this->parseArticle($entry));
        }

        return $articles;
    }


    public function parseArticle($entry)
    {
        $article[StructArticle::ARTICLE_TITLE] = (string) $entry->title;
        $article[StructArticle::ARTICLE_LINK] = (string) $entry->link;
        $article[StructArticle::ARTICLE_IMAGE] = parent::getOgImage($article[StructArticle::ARTICLE_LINK]);
        $article[StructArticle::ARTICLE_PUBLISHED_DATE] = parent::getTimestamp((string)$entry->pubDate);

        $article[StructArticle::ARTICLE_CONTENT] = (string) $entry->description;
        $article[StructArticle::ARTICLE_RSS_ID] = $this->feedId;

        return $article;
    }
}
