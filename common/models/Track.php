<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tracks".
 * @property int $id
 * @property int $soundcloud_track_id
 * @property int $artist_id
 * @property string $title
 * @property int $duration
 * @property int $playback_count
 * @property int $comments_count
 * @property int $created_at
 * @property int $updated_at
 */
class Track extends \yii\db\ActiveRecord
{

    public static function tableName(): string
    {
        return 'tracks';
    }

    public function rules(): array
    {
        return [
            [['soundcloud_track_id', 'artist_id'], 'integer'],
            [['artist_id'], 'required'],
            [['title'], 'string'],
            [['title'], 'required'],
            [['duration', 'playback_count', 'comments_count', 'created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at'], 'default', 'value' => (new \DateTimeImmutable())->getTimestamp()],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'Track ID',
            'soundcloud_track_id' => 'SoundCloud track ID',
            'artist_id' => 'Artist ID',
            'title' => 'Title',
            'duration' => 'Duration',
            'playback_count' => 'Playback count',
            'comments_count' => 'Comments count',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ];
    }

    public static function getBySoundCloudId(int $SoundCloudTrackId): ?Track
    {
        return self::find()->where(['soundcloud_track_id' => $SoundCloudTrackId])->one();
    }
}
