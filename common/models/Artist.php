<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "artists".
 * @property int $id
 * @property int $soundcloud_id
 * @property string $username
 * @property string $full_name
 * @property string $city
 * @property int $followers_count
 * @property int $created_at
 * @property int $updated_at
 */
class Artist extends ActiveRecord
{

    public static function tableName(): string
    {
        return 'artists';
    }

    public function rules(): array
    {
        return [
            [['soundcloud_id'], 'integer'],
            [['soundcloud_id'], 'required'],
            [['username', 'full_name', 'city'], 'string'],
            [['username'], 'required'],
            [['followers_count', 'created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at'], 'default', 'value' => (new \DateTimeImmutable())->getTimestamp()],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'Artist ID',
            'soundcloud_id' => 'SoundCloud ID',
            'username' => 'Username',
            'full_name' => 'Full name',
            'city' => 'City',
            'followers_count' => 'Followers count',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ];
    }

    public static function getArtistBySoundCloudID(int $id): ?Artist
    {
        return self::find()->where(['soundcloud_id' => $id])->one();
    }
}
