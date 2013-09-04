INSERT INTO `games` (`id`, `description`, `name`, `year`, `publisher`, `order`, `createdOn`) 
VALUES(1, 'Space MMORPG', 'EVE online', '2000', 'CCP games', '1', '2012-12-11'),
      (2, 'Indie atmospheric platform game', 'Limbo', '2009', 'Playdead', '2', '2012-12-10'),
      (3, 'Indie atmospheric game', 'Superbrothers: Sword & Sworcery', '2010', 'Capybara Games', '3', '2012-12-01');
      
INSERT INTO `users` (`id`, `username`, `hashedPassword`,                          `salt`,                             `role`)
VALUES              (1, 'figura4',  'da93b36067b42a697a8183adcccc593af980498d', '950cc1a15e8bb6fcfad3914bf0122e19', 'admin');

INSERT INTO `tags`  (`id`, `name`, `order`)
VALUES(1, 'space', 1),
      (2, 'sci-fi', 2),
      (3, 'fantasy', 3),
      (4, 'retro', 4),
      (5, 'dark', 5),
      (6, 'noire', 6),
      (7, 'indie', 7);
      
INSERT INTO `screenshots` (`id`, `gameId`, `description`, `resolution00`, `pageTitle`, `userId`, `published`, `ratingSum`, `votes`, `createdOn`) 
VALUES(1, 1, 'A freefalling bungee jumping Heron ship (if such thing is possible in space...). Notice the Amarr space station in the background; this Heron pilot is way out of Caldari space.', 'caldari-heron.jpg', 'Station bungee jumping', 1, 1, 0, 0, '2012-12-01'),
      (2, 3, 'The warrior hero is waiting for the dark moon to finally come. In the meantime, he goes for a picnic on the lake with her fellow sheep friends.', 'swordandsworcery_pc_2012-12-08.jpg', 'A peaceful meadow', 1, 1, 0, 0, '2012-12-11'),
      (3, 2, 'The limbo is far, far away. Many gruesome deaths still lay our path to the end. Our hero dies the millionth time electrocuted by a giant H.', 'Limbo2012-12-08.jpg', 'Dead by a dirty cheap hotel', 1, 1, 0, 0, '2012-12-08');
      
INSERT INTO `tagsScreenshots` (`id`, `tagId`, `screenshotId`)
VALUES(1, 1, 1),
      (2, 2, 1),
      (3, 3, 2),
      (4, 4, 2),
      (5, 5, 3),
      (6, 6, 3),
      (7, 7, 3);
      