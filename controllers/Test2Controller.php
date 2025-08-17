<?php

namespace app\controllers;

use app\models\test2\Chart1;
use app\models\test2\Chart2;
use app\models\test2\FilterForm;
use app\models\test2\Log;
use app\models\test2\LogReader;
use app\models\test2\UploadForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\UploadedFile;

class Test2Controller extends Controller
{
    public $layout = 'test2';

    public function actionIndex() {
        $filterModel = new FilterForm();

        $filterData = [];

        if (Yii::$app->request->isPost) {
            $filterModel->load(Yii::$app->request->post());
            $filterData = $filterModel->getData();
        }

        $chart1Model = new Chart1(['logData' => Log::getLogsForChart1($filterData)]);
        $chart2Model = new Chart2(['logData' => Log::getLogsForChart2($filterData)]);

        $dataProvider = new ActiveDataProvider([
            'query' => Log::getQueryForTable1($filterData),
            'sort' => [
                'attributes' => [
                    'date', 'queryCount', 'topUrl', 'topBrowser'
                ]
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $params = [
            'chart1Model' => $chart1Model,
            'chart2Model' => $chart2Model,
            'dataProvider' => $dataProvider,
            'filterModel' => $filterModel,
            'platformTypes' => Log::getPlatformTypes(),
            'architectureTypes' => Log::getArchitectureTypes(),
        ];
        return $this->render('index', $params);
    }

    public function actionUpload()
    {
        $formModel = new UploadForm();

        if (Yii::$app->request->isPost) {
            $formModel->logFile = UploadedFile::getInstance($formModel, 'logFile');

            if ($formModel->validate()) {
                $logReader = new LogReader();

                $stream = fopen($formModel->logFile->tempName, 'r');
                $logReader->readAndSave($stream);
            }
        }

        return $this->render('upload', ['formModel' => $formModel]);
    }
}