<?php

namespace app\models\test2;

use yii\base\Model;

class Chart1 extends Model
{
    public array $logData;

    public function getChartCategories(): array {
        $dates = [];

        foreach ($this->logData as $date => $count) {
            $dates[] = $date;
        }

        return $dates;
    }

    public function getData(): array {
        $data = [];

        foreach ($this->logData as $date => $count) {
            $data[0]['name'] = 'line 1';
            $data[0]['data'][] = $count;
        }

        return $data;
    }
}