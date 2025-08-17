<?php

namespace app\models\test2;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $logFile;

    public function rules()
    {
        return [
            ['logFile', 'file', 'skipOnEmpty' => false, 'extensions' => 'log'],
        ];
    }
}