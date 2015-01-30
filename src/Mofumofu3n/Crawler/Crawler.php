<?php
namespace Mofumofu3n\Crawler;

use Mofumofu3n\Crawler\Parser\ParserFactory;

class Crawler extends AbstractCrawler
{

    public function __construct($feeds)
    {
        parent::__construct($feeds);
    }

    /**
     * 通信成功時の処理
     * @param $feedUrl
     * @param $content
     * @return array feedの記事群
     */
    protected function success($feedUrl, $content)
    {
        $decode = simplexml_load_string($content);
        $type = $decode->getName();

        $parser = ParserFactory::factory($type);

        if (!isset($parser)) {
            return NULL;
        }

        $parser->setFeedUrl($feedUrl);
        $articles = $parser->parse($decode);
        return $articles;
    }

    /**
     * 通信失敗時の処理
     * @param $feedUrl
     * @param int $code
     */
    protected function fail($feedUrl, $code)
    {
    }
}
