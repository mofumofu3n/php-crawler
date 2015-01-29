<?php
namespace Mofumofu3n\Crawler\Parser;

class ParserFactory
{
    /**
     * RSSの種類に合わせてパーサーを返す
     *
     * @static
     * @access public
     * @param $type string RSSのタイプ(RDF, rss, feed)
     * @return AtomParser|RdfParser|RssParser|null
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
