<?php
namespace Mofumofu3n\Crawelr\Parser;

abstract class BaseParser
{
    protected $feedId;

    public function setFeedId($feedId)
    {
        $this->feedId = $feedId;
    }

    /**
     * parseArticle
     * 記事をループする
     *
     * @param mixed $rssData
     * @abstract
     * @access protected
     * @return void
     */
    abstract public function parse($rssData);

    /**
     * parseArticle
     * 記事をパースする
     *
     * @param mixed $article
     * @access public
     * @return void
     */
    abstract protected function parseArticle($article);

    /**
     * getOgImage
     * OGイメージを取得
     *
     * @param mixed $url
     * @access public
     * @return void
     */
    protected function getOgImage($url)
    {
        $source;
        try {
            ob_start();
            $source = @file_get_contents($url);
            $warning = ob_get_contents();
            ob_end_clean();
            if ($warning) {
                throw new Exception($warning);
            }
        } catch (Exception $e) {
            echo 'Error file_get_contents';
            return '';
        }
        
        preg_match('/<meta property="og:image" content="(.*?)"\s{0,1}\/{0,1}>/i', $source, $image);
        if (isset($image[1])) {
            return $image[1];
        } else {
            return '';
        }
    }

    protected function getTimestamp($published_date)
    {
        $datetime = new \DateTime($published_date);
        return $datetime->getTimestamp();
    }
}
