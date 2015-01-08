<?php
namespace Mofumofu3n\Crawler;

abstract class AbstractCrawler
{
    protected $feeds;

    public function __construct($feeds)
    {
        $this->feeds = $feeds;
    }

    /**
     * getContents
     * 引数に渡されたURLの配列かURLの文字列かで処理を分ける
     *
     * @param mixed $url
     * @access public
     * @return void
     */
    public function getContents()
    {
        if (is_array($this->feeds)) {
            $this->getMultiContents();
        } else {
            $this->getSingleContents();
        }
    }

    /**
     * getSingleContents
     * cURLで指定されたURLのコンテンツを取得する
     *
     * @param $url
     * @access public
     * @return void
     */
    public function getSingleContents()
    {
        $conn = curl_init($this->feeds->url);
        $this->setCurlOption($conn);

        // cURLの実行
        $contents = curl_exec($conn);

        $statusCode = curl_getinfo($conn, CURLINFO_HTTP_CODE);
        if ($statusCode < 300 && $statusCode >= 200) {
            // 通信成功時
            $this->success($this->feeds->id, $contents);
        } else {
            // 通信失敗時
            $this->fail($statusCode, $feed->url);
        }
        curl_close($conn);
    }

    /**
     * APIへの接続をマルチスレッドで行う
     */
    public function getMultiContents()
    {
        // マルチハンドルの用意
        $multiHandle = curl_multi_init();

        // 複数のハンドルを保持する
        $handleList = array();

        // 指定されたURLをマルチハンドルに登録する
        foreach ($this->feeds as $feed) {
            $url = $feed->url;
            $handleList[$url] = curl_init($url);
            $this->setCurlOption($handleList[$url]);
            curl_multi_add_handle($multiHandle, $handleList[$url]);
        }

        // 全ての処理が完了するまで待つ
        $running = null;
        while (true) {
            if ($running === 0) {
                break;
            }
            curl_multi_exec($multiHandle, $running);
        }

        foreach ($this->feeds as $feed) {
            $url = $feed->url;
            // ステータスコード
            $statusCode = curl_getinfo($handleList[$url], CURLINFO_HTTP_CODE);
            if ($statusCode < 300 && $statusCode >= 200) {
                // 通信成功時
                $this->success($feed->id, curl_multi_getcontent($handleList[$url]));
            } else {
                // 通信失敗時
                $this->fail($statusCode, $url);
            }

            // ハンドルを閉じる
            curl_multi_remove_handle($multiHandle, $handleList[$url]);
            curl_close($handleList[$url]);
        }

        curl_multi_close($multiHandle);
    }

    /**
     * Curlのオプションを指定する
     */
    protected function setCurlOption($maltiHundle)
    {
        // curl_exec()の結果を文字列として返す
        curl_setopt($maltiHundle, CURLOPT_RETURNTRANSFER, true);

        // タイムアウトを30秒に設定
        curl_setopt($maltiHundle, CURLOPT_TIMEOUT, 30);

        // リダイレクトを3回まで深ぼる
        curl_setopt($maltiHundle, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($maltiHundle, CURLOPT_MAXREDIRS, 3);
    }

    /**
     * 通信成功時の処理
     */
    abstract protected function success($feedId, $content);

    /**
     * 通信失敗時の処理
     *
     * @param mixed $code
     * @param mixed $url
     * @abstract
     * @access protected
     * @return void
     */
    abstract protected function fail($code, $url);
}
