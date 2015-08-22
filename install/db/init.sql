ALTER TABLE  `prefix_topic` ADD  `topic_status` INT UNSIGNED NOT NULL DEFAULT  '0',
ADD INDEX (  `topic_status` ) ;