--
-- Definition of table `games`
--

DROP TABLE IF EXISTS games;

CREATE TABLE  `games` (
  `id`				int(10) unsigned NOT NULL auto_increment,
  `description`			text NOT NULL,
  `name`			varchar(80),
  `year`			smallint unsigned,
  `publisher`		varchar(80),
  `order`			int(10) unsigned NOT NULL DEFAULT 1000,
  `createdOn` 			datetime,
  `updatedOn` 			timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  INDEX `name` (`name`),
  INDEX `year` (`year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;