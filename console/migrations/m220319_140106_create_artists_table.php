<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%artists}}`.
 */
class m220319_140106_create_artists_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%artists}}', [
            'id' => $this->primaryKey(),
            'soundcloud_id' => $this->integer()->notNull(),
            'username' => $this->string()->notNull(),
            'full_name' => $this->string()->notNull(),
            'city' => $this->string()->notNull(),
            'followers_count' => $this->integer()->notNull(),
            'created_at' => $this->bigInteger()->notNull(),
            'updated_at' => $this->bigInteger()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%artists}}');
    }
}
