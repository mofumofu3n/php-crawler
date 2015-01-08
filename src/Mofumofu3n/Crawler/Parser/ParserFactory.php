<?php
namespace Mofumofu3n\Crawelr\Parser;

class ParserFactory
{

    /**
     * RSSの種類に合わせてパーサーを返す
     *
     * @param mixed $rssData
     * @static
     * @access public
     * @return void
     */
    public static function factory($type)
    {
        $parser = null;
        if ($type === 'RDF') {
            // rss 1.0
            $parser = new RdfParser();
        } elseif ($type === 'rss') {
            // rss 2.0
            $parser = new RssParser();
        } elseif ($type === 'feed') {
            // Atom
            $parser = new AtomParser();
        }

        return $parser;
    }
}
