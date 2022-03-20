<?php

namespace console\components\spider\dto;

class Artist
{
    private int $soundCloudId;
    private string $username;
    private string $fullName;
    private string $city;
    private int $followersCount;

    /**
     * @var Track[]
     */
    private array $tracks;

    /**
     *
     * @param Track[] $tracks
     */
    public function __construct(int $soundCloudId, string $username, string $fullName, string $city, int $followersCount, array $tracks)
    {
        $this->soundCloudId = $soundCloudId;
        $this->username = $username;
        $this->fullName = $fullName;
        $this->city = $city;
        $this->followersCount = $followersCount;
        $this->tracks = $tracks;
    }

    public function getSoundCloudId(): int
    {
        return $this->soundCloudId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getFollowersCount(): int
    {
        return $this->followersCount;
    }

    /**
     *
     * @return  Track[]
     */
    public function getTracks(): array
    {
        return $this->tracks;
    }
}
