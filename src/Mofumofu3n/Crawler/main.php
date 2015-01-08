<?php
namespace Fuel\Tasks;

use Fuel\Core\DB;
use Fuel\Core\DBUtil;

require_once(dirname(__FILE__) ."/Crawler.php");

class Main
{
    // 取得するページ数
    const PAGE_NUM = 20;

    public function __autoload($class_name)
    {
        require_once $class_name . '.php';
    }

    public static function run()
    {
        $feeds = \Model_Feed::find('all');

        $crawler = new Crawler(array_merge($feeds));
        $crawler->getContents();
    }
}
