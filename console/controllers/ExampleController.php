<?php

namespace console\controllers;

use console\components\spider\ArtistInfoHandler;
use console\components\spider\SoundCloudParser;
use Yii;
use yii\console\Controller;
use DiDom\Exceptions\InvalidSelectorException;


class ExampleController extends Controller
{
    private const TEST_LINK = 'https://soundcloud.com/rnbstellar/tracks';

    /**
     * @throws InvalidSelectorException
     */
    public function actionTest()
    {
        $handler = new ArtistInfoHandler(new SoundCloudParser());
        print_r($handler->saveArtistInfo(self::TEST_LINK));
    }
}
