--
-- Definition of table `tags`
--

DROP TABLE IF EXISTS tags;

CREATE TABLE  `tags` (
  `id`				int(10) unsigned NOT NULL auto_increment,
  `name`			varchar(80),
  `description`		text NOT NULL,
  `order`			int(10) unsigned DEFAULT 1000,
  PRIMARY KEY  (`id`),
  INDEX `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;