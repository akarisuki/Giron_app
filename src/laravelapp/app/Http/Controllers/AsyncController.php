<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Promise;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Aws\Rekognition\RekognitionClient;

class AsyncController extends Controller
{
    public function request()
    {
        $start_time = microtime(true);
        dump('開始');

        $client = new Client();
        $promises = [];

        for($i = 1 ; $i <= 4; $i++) {

            $url = route('async.response', $i); // ４つのURLを作成
            $promises[] = $client->getAsync($url) // Promise（非同期通信のためのアクセス情報）をつくる
                ->then(
                    function($response) use($i, $start_time) { // アクセスに成功した時

                        $end_time = microtime(true) - $start_time;
                        dump('非同期通信の終了 その'. $i .'： '. $end_time .' 秒');

                    },
                    function(RequestException $e) { // アクセスに失敗したとき

                        dump($e->getMessage());

                    }
                );

        }

        $responses = Promise\Utils::settle($promises)->wait();
        dump('終了：'. microtime(true) - $start_time .' 秒');
    }

    public function response($id) { // 重たい処理のテスト

        $id = intval($id);

        if($id === 4) {

            abort(404); // $id が 4 の場合だけ 404 エラーを返す

        }

        $seconds = pow($id, 2); // $id を2乗して秒数にする
        sleep($seconds);

    }
}
