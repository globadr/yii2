<?php

namespace app\models\test2;

use yii\base\Model;

class FilterForm extends Model
{
    public $dateStart;
    public $dateFinish;
    public $platform;
    public $architecture;

    public function rules()
    {
        return [
            ['dateStart', 'string'],
            ['dateFinish', 'string'],
            ['platform', 'string'],
            ['architecture', 'integer'],
        ];
    }

    public function getData(): array {
        return [
            'dateStart' => $this->dateStart,
            'dateFinish' => $this->dateFinish,
            'platform' => $this->platform,
            'architecture' => $this->architecture,
        ];
    }
}