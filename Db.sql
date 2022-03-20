CREATE
DATABASE soundcloud_parser;

CREATE TABLE `soundcloud_parser`.`artists`
(
    `id`              INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `soundcloud_id`   INT(11) NOT NULL UNIQUE,
    `username`        VARCHAR(255) NOT NULL,
    `full_name`       VARCHAR(255) NOT NULL,
    `city`            VARCHAR(255) NOT NULL,
    `followers_count` INT(11) NOT NULL,
    `created_at`      BIGINT(20) NOT NULL,
    `updated_at`      BIGINT(20) NOT NULL
);

CREATE TABLE `soundcloud_parser`.`tracks`
(
    `id`                  INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `soundcloud_track_id` INT(11) NOT NULL UNIQUE,
    `artist_id`           INT(11) NOT NULL,
    `title`               VARCHAR(255) NOT NULL,
    `duration`            INT(11) NOT NULL,
    `playback_count`      INT(11) NOT NULL,
    `comments_count`      INT(11) NOT NULL,
    `created_at`          BIGINT(20) NOT NULL,
    `updated_at`          BIGINT(20) NOT NULL,
    FOREIGN KEY (artist_id) REFERENCES artists (id)
);
