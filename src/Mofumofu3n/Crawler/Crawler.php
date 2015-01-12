<?php
namespace Mofumofu3n\Crawler;

class Crawler extends BaseCurl
{

    public function __construct($feeds)
    {
        parent::__construct($feeds);
    }

    /**
     * 通信成功時の処理
     */
    protected function success($feedId, $content)
    {
        $decode = simplexml_load_string($content);
        $type = $decode->getName();

        $parser = ParserFactory::factory($type);

        if (!isset($parser)) {
            return;
        }

        $parser->setFeedId($feedId);

        // 記事をパース
        $articles = $parser->parse($decode);

        // DBに格納
        foreach ($articles as $article) {
            \Model_Article::insert($article);
        }
    }

    /**
     * 通信失敗時の処理
     */
    protected function fail($code, $url)
    {
        print($code . ": ". $url. "\n");
    }
}
