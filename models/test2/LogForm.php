<?php

namespace app\models\test2;

use yii\base\Model;
use yii\web\UploadedFile;

class LogForm extends Model {
    public ?UploadedFile $logFile = null;

    public function rules() {
        return [
            [['logFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'log'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->logFile->saveAs('uploads/' . $this->logFile->baseName . '.' . $this->logFile->extension);
            return true;
        } else {
            return false;
        }
    }
}