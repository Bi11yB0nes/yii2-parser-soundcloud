<?php

namespace console\components\spider\dto;

class Track
{
    private int $soundCloudTrackId;
    private string $title;
    private int $duration;
    private int $playback_count;
    private int $comments_count;

    public function __construct(int $soundCloudTrackId, string $title, int $duration, int $playback_count, int $comments_count)
    {
        $this->soundCloudTrackId = $soundCloudTrackId;
        $this->title = $title;
        $this->duration = $duration;
        $this->playback_count = $playback_count;
        $this->comments_count = $comments_count;
    }

    public function getSoundCloudTrackId(): int
    {
        return $this->soundCloudTrackId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getPlaybackCount(): int
    {
        return $this->playback_count;
    }

    public function getCommentsCount(): int
    {
        return $this->comments_count;
    }
}
