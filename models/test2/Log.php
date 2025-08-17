<?php

namespace app\models\test2;

use yii\db\Query;

class Log extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'logs';
    }

    public static function getLogsForChart1(array $filter): array
    {
        $logs = [];

        $query = (new Query())
            ->select([
                'dateTime' => 'FROM_UNIXTIME(l.date, "%Y-%m-%d %H-00")',
                'count' => 'COUNT(*)'
            ])
            ->from(['l' => static::tableName()])
            ->groupBy('dateTime');

        if (!empty($filter['dateStart'])) $query->andWhere(['>=', 'l.date', strtotime($filter['dateStart'])]);
        if (!empty($filter['dateFinish'])) $query->andWhere(['<', 'l.date', strtotime($filter['dateFinish'])]);
        if (!empty($filter['platform'])) $query->andWhere(['=', 'l.platform', $filter['platform']]);
        if (!empty($filter['architecture'])) $query->andWhere(['=', 'l.architecture', $filter['architecture']]);

        foreach ($query->all() as $record) {
            $logs[$record['dateTime']] = $record['count'];
        }

        return $logs;
    }

    public static function getLogsForChart2(): array
    {
        $logs = [];

        $query = (new Query())
            ->select([
                'dateTime' => 'FROM_UNIXTIME(l.date, "%Y-%m-%d %H-00")',
                'l.browser',
                'count' => 'COUNT(*)'
            ])
            ->from(['l' => static::tableName()])
            ->groupBy([
                'dateTime',
                'l.browser'
            ]);

        if (!empty($filter['dateStart'])) $query->andWhere(['>=', 'l.date', strtotime($filter['dateStart'])]);
        if (!empty($filter['dateFinish'])) $query->andWhere(['<', 'l.date', strtotime($filter['dateFinish'])]);
        if (!empty($filter['platform'])) $query->andWhere(['=', 'l.platform', $filter['platform']]);
        if (!empty($filter['architecture'])) $query->andWhere(['=', 'l.architecture', $filter['architecture']]);

        foreach ($query->all() as $record) {
            $logs[$record['dateTime']][$record['browser']] = $record['count'];
        }

        return $logs;
    }

    public static function getQueryForTable1(array $filter): Query
    {
        $query = (new Query())
            ->select([
                'dateTime1' => "FROM_UNIXTIME(l.date, '%d.%m.%Y %H:%i')",
                'queryCount' => 'Count(*)'
            ])
            ->from(['l' => static::tableName()])
            ->groupBy('dateTime1');

        if (!empty($filter['dateStart'])) $query->andWhere(['>=', 'l.date', strtotime($filter['dateStart'])]);
        if (!empty($filter['dateFinish'])) $query->andWhere(['<', 'l.date', strtotime($filter['dateFinish'])]);
        if (!empty($filter['platform'])) $query->andWhere(['=', 'l.platform', $filter['platform']]);
        if (!empty($filter['architecture'])) $query->andWhere(['=', 'l.architecture', $filter['architecture']]);

        return (new Query())
            ->select([
                'date' => 't1.dateTime1',
                'topUrl' => 't2.url',
                'topBrowser' => 't3.browser',
                't1.queryCount'
            ])
            ->from(
                [ 't1' => $query ],
            )->innerJoin(
                ['t2' => (new Query())
                    ->select([
                        'dateTime2' => "FROM_UNIXTIME(l.date, '%d.%m.%Y %H:%i')",
                        'l.url',
                        'queryCount' => 'Count(*)'
                    ])
                    ->from(['l' => static::tableName()])
                    ->groupBy([
                        'dateTime2',
                        'l.url'
                    ])->orderBy('queryCount DESC')],
                't2.dateTime2 = t1.dateTime1'
            )->innerJoin(
                ['t3' => (new Query())
                    ->select([
                        'dateTime3' => "FROM_UNIXTIME(l.date, '%d.%m.%Y %H:%i')",
                        'l.browser',
                        'queryCount' => 'Count(*)'
                    ])
                    ->from(['l' => static::tableName()])
                    ->groupBy([
                        'dateTime3',
                        'l.browser'
                    ])->orderBy('queryCount DESC')],
                't3.dateTime3 = t1.dateTime1'
            );
    }

    public static function getPlatformTypes(): array {
        $types = [];

        foreach ((new Query())->select('platform')
            ->from(static::tableName())
            ->groupBy('platform')
        ->all() as $record) {
            $types[$record['platform']] = $record['platform'];
        }

        return $types;
    }

    public static function getArchitectureTypes(): array {
        $types = [];

        foreach ((new Query())->select('architecture')
                     ->from(static::tableName())
                     ->groupBy('architecture')
                     ->all() as $record) {
            $types[$record['architecture']] = $record['architecture'];
        }

        return $types;
    }
}