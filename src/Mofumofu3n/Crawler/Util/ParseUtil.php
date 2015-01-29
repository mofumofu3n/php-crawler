<?php
namespace Mofumofu3n\Crawler\Util;


use Exception;

class ParseUtil {

    /**
     * getOgImage
     * OGイメージを取得
     *
     * @param $url
     * @access public
     * @return string 画像のUrl
     */
    public static function getOgImage($url)
    {
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

}