<?php

namespace console\components\spider;

use console\components\spider\dto\Artist;
use console\components\spider\dto\Track;
use DiDom\Document;
use DiDom\Exceptions\InvalidSelectorException;

class SoundCloudParser
{
    /**
     * @throws InvalidSelectorException
     */
    public function getArtistInfo(string $link): Artist
    {
        $document = new Document($link, true);
        $artistSoundCloudId = $this->getSoundCloudId($document);
        $artistUsername = $this->getArtistUsername($document);
        $artistFullName = $this->getArtistFullName($document);
        $artistCity = $this->getArtistCity($document);
        $artistFollowersCount = $this->getArtistFollowersCount($document);
        $tracks = $this->getTracks($document);

        return new Artist($artistSoundCloudId, $artistUsername, $artistFullName, $artistCity, $artistFollowersCount, $tracks);
    }

    /**
     *
     * @return  Track[]
     * @throws InvalidSelectorException
     */
    private function getTracks(Document $document): array
    {
        $data = [];
        $trackLinks = $this->getTrackLinks($document);

        $hostUrl = $this->getHostUrl($document);

        foreach ($trackLinks as $link) {
            $document = new Document($hostUrl . $link, true);
            $data[] = $this->getTrack($document);
        }

        return $data;
    }

    /**
     * @throws InvalidSelectorException
     */
    private function getSoundCloudId(Document $document): int
    {
        $scriptScriptContent = $this->getDataScriptContent($document);
        $regExp = '/"id":.+?\"/';

        return $this->getIntDataByReg($regExp, $scriptScriptContent);
    }

    /**
     * @throws InvalidSelectorException
     */
    private function getArtistUsername(Document $document): string
    {
        $scriptScriptContent = $this->getDataScriptContent($document);
        $regExp = '/"username":.+?\"/';

        return $this->getStringDataByReg($regExp, $scriptScriptContent);
    }

    /**
     * @throws InvalidSelectorException
     */
    private function getArtistFullName(Document $document): string
    {
        $scriptScriptContent = $this->getDataScriptContent($document);
        $regExp = '/"full_name":.+?\"/';

        return $this->getStringDataByReg($regExp, $scriptScriptContent);
    }

    /**
     * @throws InvalidSelectorException
     */
    private function getArtistCity(Document $document): string
    {
        $scriptScriptContent = $this->getDataScriptContent($document);
        $regExp = '/"city":.+?\"/';

        return $this->getStringDataByReg($regExp, $scriptScriptContent);
    }

    /**
     * @throws InvalidSelectorException
     */
    private function getArtistFollowersCount(Document $document): int
    {
        $scriptScriptContent = $this->getDataScriptContent($document);
        $regExp = '/"followers_count":.+?,/';

        return $this->getIntDataByReg($regExp, $scriptScriptContent);
    }


    /**
     * @throws InvalidSelectorException
     */
    private function getTrackLinks(Document $document): array
    {
        $data = [];
        $elements = $document->find('.audible a[itemprop="url"]');
        if (count($elements) > 0) {
            foreach ($elements as $trackElement) {
                $link = $trackElement->getAttribute('href');
                $data[] = $link;
            }
        }
        return $data;
    }

    /**
     * @throws InvalidSelectorException
     */
    private function getTrack(Document $document): Track
    {
        $trackSoundCloudTrackId = $this->getSoundCloudTrackId($document);
        $trackTitle = $this->getTitle($document);
        $trackDuration = $this->getDuration($document);
        $trackPlaybackCount = $this->getPlaybackCount($document);
        $trackCommentCount = $this->getCommentsCount($document);

        return new Track($trackSoundCloudTrackId, $trackTitle, $trackDuration, $trackPlaybackCount, $trackCommentCount);
    }

    /**
     * @throws InvalidSelectorException
     */
    private function getSoundCloudTrackId(Document $document): int
    {
        $scriptScriptContent = $this->getDataScriptContent($document);
        $regExp = '/"urn":"soundcloud:tracks:.+?\"/';

        return $this->getIntDataByReg($regExp, $scriptScriptContent);
    }

    /**
     * @throws InvalidSelectorException
     */
    private function getTitle(Document $document): string
    {
        $scriptScriptContent = $this->getDataScriptContent($document);
        $regExp = '/"title":.+?\"/';

        return $this->getStringDataByReg($regExp, $scriptScriptContent);
    }

    /**
     * @throws InvalidSelectorException
     */
    private function getDuration(Document $document): int
    {
        $scriptScriptContent = $this->getDataScriptContent($document);
        $regExp = '/"full_duration":.+?,/';

        return $this->getIntDataByReg($regExp, $scriptScriptContent);
    }

    /**
     * @throws InvalidSelectorException
     */
    private function getPlaybackCount(Document $document): int
    {
        $scriptScriptContent = $this->getDataScriptContent($document);
        $regExp = '/"playback_count":.+?,/';

        return $this->getIntDataByReg($regExp, $scriptScriptContent);
    }

    /**
     * @throws InvalidSelectorException
     */
    private function getCommentsCount(Document $document): int
    {
        $scriptScriptContent = $this->getDataScriptContent($document);
        $regExp = '/"comment_count":.+?,/';

        return $this->getIntDataByReg($regExp, $scriptScriptContent);
    }


    /**
     * @throws InvalidSelectorException
     */
    private function getHostUrl(Document $document): string
    {
        $scriptScriptContent = $this->getDataScriptContent($document);
        $regExp = '/"permalink_url":.+?,/';
        $permalinkUrl = parse_url($this->getStringDataByReg($regExp, $scriptScriptContent));

        return $permalinkUrl['scheme'] . '://' . $permalinkUrl['host'];
    }

    /**
     * @throws InvalidSelectorException
     */
    private function getDataScriptContent(Document $document): string
    {
        $bodyScriptElements = $document->find('body > script');
        $scriptBody = null;
        foreach ($bodyScriptElements as $element) {
            if (strpos($element->text(), 'window.__sc_hydration') !== false) {
                $scriptBody = ($element->text());
                break;
            }
        }
        return $scriptBody;
    }

    private function getStringDataByReg(string $regExp, string $text): string
    {
        preg_match_all($regExp, $text, $matches);
        return explode('"', end($matches[0]))[3];
    }

    private function getIntDataByReg(string $regExp, string $text): int
    {
        preg_match_all($regExp, $text, $matches);
        $array = explode(':', end($matches[0]));
        return (trim(trim(end($array), '"'), ','));
    }
}
