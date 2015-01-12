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
        $feedA = new SingleFeed();
        $feedA->url = "http://yaraon.blog109.fc2.com/?xml";
        $feedA->id = 0;
        $this->singleDataset = $feedA;

        $feedB = new SingleFeed();
        $feedB->url = "http://otanews.livedoor.biz/index.rdf";
        $feedB->id = 1;
        $this->multiDataset = array($feedA, $feedB);
    }

    /**
     * @requires extension curl
     */
    public function testSingleGetContents()
    {
        $stub = $this->getMockForAbstractClass('Mofumofu3n\Crawler\AbstractCrawler', array($this->singleDataset));
        $stub->expects($this->once())
            ->method('success');
        $stub->getContents();
    }

    public function testMultiGetContents()
    {
        $stub = $this->getMockForAbstractClass('Mofumofu3n\Crawler\AbstractCrawler', array($this->multiDataset));

        $stub->expects($this->at(0))->method('success');
        $stub->expects($this->at(1))->method('success');
        $stub->getContents();
    }

    public function testAtomParser()
    {
        $parser = new AtomParser();
    }

    public function testRdfParser()
    {
        $parser = new RdfParser();
    }

    public function testRssParser()
    {
        $parser = new RssParser();
    }
}

class SingleFeed
{
    public $url;
    public $id;
}
