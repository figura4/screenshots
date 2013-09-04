--
-- Definition of table `screenshots`
--

DROP TABLE IF EXISTS screenshots;

CREATE TABLE  `screenshots` (
  `id`				int(10) unsigned NOT NULL auto_increment,
  `gameId`  			int(10) unsigned NOT NULL,
  `description`			text NOT NULL,
  `resolution00`		varchar(200),
  `resolution01`		varchar(200),
  `resolution02`		varchar(200),
  `resolution03`		varchar(200),
  `resolution04`		varchar(200),
  `resolution05`		varchar(200),
  `resolution06`		varchar(200),
  `resolution07`		varchar(200),
  `pageTitle` 			varchar(200) NOT NULL,
  `userId`  			int(10) unsigned NOT NULL,
  `published` 			bool NOT NULL DEFAULT FALSE,
  `ratingSum`			int(10) unsigned NOT NULL DEFAULT 4,
  `votes`				int(10) unsigned NOT NULL DEFAULT 1,
  `pubDate` 			date,
  `createdOn` 			datetime,
  `updatedOn` 			timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  INDEX `gameId` (`gameId`),
  INDEX `createdOn` (`createdOn`),
  FOREIGN KEY (gameId) REFERENCES games(id)
  	ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (userId) REFERENCES users(id)
  	ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;