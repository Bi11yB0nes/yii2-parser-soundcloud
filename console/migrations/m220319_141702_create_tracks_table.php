<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tracks}}`.
 */
class m220319_141702_create_tracks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tracks}}', [
            'id' => $this->primaryKey(),
            'soundcloud_track_id' => $this->integer()->unique()->notNull(),
            'artist_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'duration' => $this->integer()->notNull(),
            'playback_count' => $this->integer()->notNull(),
            'comments_count' => $this->integer()->notNull(),
            'created_at' => $this->bigInteger()->notNull(),
            'updated_at' => $this->bigInteger()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-track-artist-id',
            'tracks',
            'artist_id',
            'artists',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tracks}}');
    }
}
