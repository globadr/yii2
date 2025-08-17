<?php

namespace app\models\test2;

use yii\base\Model;

class LogReader extends Model
{
    public function readAndSave($stream)
    {
        if (is_resource($stream) and $stream) {
            while (($line = fgets($stream)) !== false) {
                try {
                    $data = $this->parse_line($line);

                    $log = new Log($data);
                    $log->save();
                } catch (\Exception $e) {
                    dump($e, $data);die;
                }
            }

            if (!feof($stream)) {
                echo "Error: unexpected fgets() fail\n";
            }

            fclose($stream);
        }
    }

    private function parse_line(string $line): array
    {
        $data = [];

        $re = '/(?<ip>[0-9.]+)\s+\-\s+\-\s\[(?<date>[^\]]+)\]\s"(?<request>[^"]*)"\s(?<code>\d+)\s+(?<size>\d+)\s"(?<url>[^"]*)"\s"(?<useragent>[^"]+)"/m';

        preg_match_all($re, $line, $matches, PREG_SET_ORDER);

        $data['ip'] = $matches[0]['ip'];
        $data['date'] = strtotime($matches[0]['date']);
        $data['url'] = $matches[0]['url'];
        $data['useragent'] = $matches[0]['useragent'];

        $browscapInfo = get_browser($data['useragent']);
        $data['platform'] = $browscapInfo->platform;
        $data['browser'] = $browscapInfo->browser;
        $data['architecture'] = $browscapInfo->platform_bits;

        return $data;
    }
}