--
-- Definition of table `figura4`.`users`
-- tabella utenti del sito
--

CREATE TABLE  `users` (
  `id`                    int(10) unsigned NOT NULL auto_increment,
  `username`             varchar(20),
  `hashedPassword`     varchar(200),
  `salt`                 varchar (200),
  `email`                 varchar(200),
  `role`                 varchar(100) NOT NULL default 'guest',
  `createdOn`             datetime,
  `updatedOn`             timestamp on update current_timestamp,
  PRIMARY KEY  (`id`),
  KEY `username` (`username`),
  KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
