<?php

namespace console\components\spider;

use common\models\Artist;
use common\models\Track;
use console\components\spider\dto\Artist as ArtistDto;
use console\components\spider\dto\Track as TrackDto;
use DiDom\Exceptions\InvalidSelectorException;

class ArtistInfoHandler
{
    private SoundCloudParser $soundCloudParser;

    public function __construct(SoundCloudParser $soundCloudParser)
    {
        $this->soundCloudParser = $soundCloudParser;
    }

    /**
     * @throws InvalidSelectorException
     */
    public function saveArtistInfo(string $link): bool
    {
        $artistInfo = $this->soundCloudParser->getArtistInfo($link);

        $artist = self::saveArtist($artistInfo);
        if (!$artist) return false;

        if (!$this->saveAllTracks($artist->id, $artistInfo)) return false;

        return true;
    }

    private function saveArtist(ArtistDto $data): ?Artist
    {
        $artist = Artist::getArtistBySoundCloudID($data->getSoundCloudId());

        $artist ?? $artist = new Artist();

        $artist->soundcloud_id = $data->getSoundCloudId();
        $artist->username = $data->getUsername();
        $artist->full_name = $data->getFullName();
        $artist->city = $data->getCity();
        $artist->followers_count = $data->getFollowersCount();
        $artist->updated_at = (new \DateTimeImmutable())->getTimestamp();

        if (!$artist->save()) return null;

        return $artist;
    }

    private function saveAllTracks(int $artistId, ArtistDto $data): bool
    {
        $tracksData = $data->getTracks();
        foreach ($tracksData as $track) {
            if (!$this->saveTrack($artistId, $track)) return false;
        }
        return true;
    }

    private function saveTrack(int $artistId, TrackDto $data): bool
    {
        $track = Track::getBySoundCloudId($data->getSoundCloudTrackId());

        $track ?? $track = new Track();

        $track->soundcloud_track_id = $data->getSoundCloudTrackId();
        $track->artist_id = $artistId;
        $track->title = $data->getTitle();
        $track->duration = $data->getDuration();
        $track->playback_count = $data->getPlaybackCount();
        $track->comments_count = $data->getCommentsCount();
        $track->updated_at = (new \DateTimeImmutable())->getTimestamp();

        if (!$track->save()) return false;

        return true;
    }
}
