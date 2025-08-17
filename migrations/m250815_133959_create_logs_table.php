<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%logs}}`.
 */
class m250815_133959_create_logs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%logs}}', [
            'id' => $this->primaryKey(),
            'ip' => $this->string(16)->notNull(),
            'date' => $this->integer()->notNull(),
            'url' => $this->text()->notNull(),
            'platform' => $this->string(255)->notNull(),
            'browser' => $this->string(255)->notNull(),
            'architecture' => $this->string(3)->notNull(),
            'useragent' => $this->text()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%logs}}');
    }
}
