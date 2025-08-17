<?php

use miloschuman\highcharts\Highcharts;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/** @var app\models\test2\Chart1 $chart1Model */
/** @var app\models\test2\Chart2 $chart2Model */

$form = ActiveForm::begin(['id' => 'filter-form', 'options' => ['class' => 'form-horizontal']]);
$formHtml = [];
$formHtml[] = $form->field($filterModel, 'dateStart')->widget(DatePicker::class, [
    'language' => 'ru',
    'dateFormat' => 'dd-MM-yyyy',
    'clientOptions' => [
        'minDate' => '-1y',
        'maxDate' => '+1y',
        'changeYear' => true,
    ]
]);

$formHtml[] = $form->field($filterModel, 'dateFinish')->widget(DatePicker::class, [
    'language' => 'ru',
    'dateFormat' => 'dd-MM-yyyy',
    'clientOptions' => [
        'minDate' => '-1y',
        'maxDate' => '+1y',
    ]
]);

$formHtml[] = $form->field($filterModel, 'platform')->listBox($platformTypes, [ 'class' => 'form-control']);
$formHtml[] = $form->field($filterModel, 'architecture')->listBox($architectureTypes, [ 'class' => 'form-control']);
$formHtml[] = Html::submitButton('Фильтровать', ['class' => 'btn btn-primary']);
echo implode(PHP_EOL, $formHtml);
ActiveForm::end();


echo Highcharts::widget([
    'options' => [
        'title' => ['text' => $chart1Model->getAttributeLabel('title')],
        'xAxis' => [
            'categories' => $chart1Model->getChartCategories()
        ],
        'yAxis' => [
            'title' => ['text' => $chart1Model->getAttributeLabel('requestCount')]
        ],
        'series' => $chart1Model->getData()
    ]
]);

echo Highcharts::widget([
    'options' => [
        'title' => ['text' => $chart2Model->getAttributeLabel('title')],
        'xAxis' => [
            'categories' => $chart2Model->getChartCategories()
        ],
        'yAxis' => [
            'title' => ['text' => $chart2Model->getAttributeLabel('requestCount')]
        ],
        'series' => $chart2Model->getData()
    ]
]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'date',
        'queryCount',
        'topUrl' => [
            'attribute' => 'topUrl',
            'format' => 'raw',
            'value' => function ($data) {
                $limit = 25;
                if (strlen($data['topUrl']) > $limit) {
                    return \yii\helpers\Html::tag('span',
                        \yii\helpers\Html::encode(substr($data['topUrl'], 0, $limit)) . '...',
                        ['title' => \yii\helpers\Html::encode($data['topUrl'])]
                    );
                }
                return \yii\helpers\Html::encode($data['topUrl']);
            },
        ],
        'topBrowser',
    ]
]);

?>