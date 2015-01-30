<?php
namespace Mofumofu3n\Crawler;

use Mofumofu3n\Crawler\AbstractCrawler;
use Mofumofu3n\Crawler\Parser\AtomParser;
use Mofumofu3n\Crawler\Parser\RdfParser;
use Mofumofu3n\Crawler\Parser\RssParser;

class CrawlerTest extends \PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->targetUrl = "http://yaraon.blog109.fc2.com/?xml";

        $this->targetUrls = array();

        array_push($this->targetUrls, "http://otanews.livedoor.biz/index.rdf");
        array_push($this->targetUrls, "http://yaraon.blog109.fc2.com/?xml");
    }

    /**
     * URLを1つ渡すとsuccessが一度呼ばれる
     */
    public function testSingleGetContents()
    {
        $stub = $this->getMockForAbstractClass('Mofumofu3n\Crawler\AbstractCrawler', array($this->targetUrl));
        $stub->expects($this->once())
            ->method('success');
        $stub->getContents();
    }

    /**
     * URLを複数渡すと数分successが呼ばれる
     */
    public function testMultiGetContents()
    {
        $stub = $this->getMockForAbstractClass('Mofumofu3n\Crawler\AbstractCrawler', array($this->targetUrls));

        $stub->expects($this->at(0))->method('success');
        $stub->expects($this->at(1))->method('success');
        $stub->getContents();
    }

    /**
     * @expectedException Exception
     */
    public function testExceptionWithAbstractCrawlerWhenNonArgs()
    {
        $stub = $this->getMockForAbstractClass('Mofumofu3n\Crawler\AbstractCrawler', array());
        $stub->getContents();
    }

    public function testCrawlerWhenOneFeed()
    {
        $crawler = new Crawler($this->targetUrl);
        $result = $crawler->getContents();
        $this->assertCount(30, $result);
    }

    public function testCrawlerWhenMultiFeed()
    {
        $crawler = new Crawler($this->targetUrls);
        $result = $crawler->getContents();
        $this->assertCount(2, $result);
        var_dump($result);
    }
}

