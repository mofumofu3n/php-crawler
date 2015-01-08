<?php
namespace Mofumofu3n\Crawler;

use Mofumofu3n\Crawler\AbstractCrawler;

class CrawlerTest extends \PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->crawler = new Crawler("http://yaraon.blog109.fc2.com/?xml");
        $this->Crawler->getContents();
    }
}

public class Crawler extends AbstractCrawler
{
    public function __construct($feeds)
    {
        parent::__construct($feeds);
    }

    protected function success($feedId, $content)
    {
        print($feedId);
    }

    protected function fail($code, $url)
    {
        print($code . ": ". $url. "\n");
    }
}
