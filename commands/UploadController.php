<?php

namespace app\commands;

use app\models\test2\LogReader;
use yii\console\Controller;
use yii\console\ExitCode;

class UploadController extends Controller
{
    public function actionIndex(string $filename)
    {
        if (file_exists($filename)) {
            $stream = fopen($filename, 'r');

            $logReader = new LogReader();
            $logReader->readAndSave($stream);
        }

        return ExitCode::OK;
    }
}