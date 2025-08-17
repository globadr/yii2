<?php

namespace app\models\test2;

use yii\base\Model;

class Chart2 extends Model
{
    public array $logData;

    public function getChartCategories(): array
    {
        $dates = [];

        foreach ($this->logData as $date => $count) {
            $dates[] = $date;
        }

        return $dates;
    }

    public function getData(): array
    {
        $data = [];

        $browser_requests = [];
        foreach ($this->logData as $date => $browsers) {
            foreach ($browsers as $browser => $count) {
                $data[$browser]['name'] = $browser;
                $data[$browser]['data'][] = $count / array_sum($browsers) * 100;

                $browser_requests[$browser] = $count;
            }
        }

        asort($browser_requests);
        $top_browsers = array_keys(array_slice($browser_requests, -3));

        foreach ($data as $key => $value) {
            if (!in_array($value['name'], $top_browsers)) unset($data[$key]);
            else $data[$key]['data'] = array_values($value['data']);
        }

        return array_values($data);
    }
}