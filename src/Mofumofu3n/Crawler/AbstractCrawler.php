<?php
namespace Mofumofu3n\Crawler;

abstract class AbstractCrawler
{
    protected $feeds;

    /**
     * @param $feeds |array|string
     */
    public function __construct($feeds)
    {
        $this->feeds = $feeds;
    }

    /**
     * getContents
     * 引数に渡されたURLの配列かURLの文字列かで処理を分ける
     *
     * @access public
     * @return array
     */
    public function getContents()
    {
        if (is_array($this->feeds)) {
            return $this->getMultiContents();
        } else {
            return $this->getSingleContents();
        }
    }

    /**
     * getSingleContents
     * cURLで指定されたURLのコンテンツを取得する
     */
    public function getSingleContents()
    {
        $conn = curl_init($this->feeds);
        $this->setCurlOption($conn);

        // cURLの実行
        $contents = curl_exec($conn);

        $articles = NULL;
        $statusCode = curl_getinfo($conn, CURLINFO_HTTP_CODE);
        if ($statusCode < 300 && $statusCode >= 200) {
            // 通信成功時
            $articles = $this->success($this->feeds, $contents);
        } else {
            // 通信失敗時
            $this->fail($statusCode, $this->feeds);
        }
        curl_close($conn);
        return $articles;
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
        foreach ($this->feeds as $feedUrl) {
            $handleList[$feedUrl] = curl_init($feedUrl);
            $this->setCurlOption($handleList[$feedUrl]);
            curl_multi_add_handle($multiHandle, $handleList[$feedUrl]);
        }

        // 全ての処理が完了するまで待つ
        $running = null;
        while (true) {
            if ($running === 0) {
                break;
            }
            curl_multi_exec($multiHandle, $running);
        }

        $feedArticles = array();
        foreach ($this->feeds as $feedUrl) {
            // ステータスコード
            $statusCode = curl_getinfo($handleList[$feedUrl], CURLINFO_HTTP_CODE);
            if ($statusCode < 300 && $statusCode >= 200) {
                // 通信成功時
                $articles = $this->success($feedUrl, curl_multi_getcontent($handleList[$feedUrl]));
                if (!is_null($articles)) {
                    array_push($feedArticles, $articles);
                }
            } else {
                // 通信失敗時
                $this->fail($statusCode, $feedUrl);
            }

            // ハンドルを閉じる
            curl_multi_remove_handle($multiHandle, $handleList[$feedUrl]);
            curl_close($handleList[$feedUrl]);
        }

        curl_multi_close($multiHandle);
        return $feedArticles;
    }

    /**
     * Curlのオプションを指定する
     *
     * @param $multiHandle
     */
    protected function setCurlOption($multiHandle)
    {
        // curl_exec()の結果を文字列として返す
        curl_setopt($multiHandle, CURLOPT_RETURNTRANSFER, true);

        // タイムアウトを30秒に設定
        curl_setopt($multiHandle, CURLOPT_TIMEOUT, 30);

        // リダイレクトを3回まで深ぼる
        curl_setopt($multiHandle, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($multiHandle, CURLOPT_MAXREDIRS, 3);
    }

    /**
     * 通信成功時の処理
     * @param $feedUrl
     * @param $content
     */
    abstract protected function success($feedUrl, $content);

    /**
     * 通信失敗時の処理
     * @param $feedUrl
     * @param int $code
     */
    abstract protected function fail($feedUrl, $code);
}
