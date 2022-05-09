CREATE TABLE `users` (
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','moderator','admin') DEFAULT 'user',
  `status` int DEFAULT 0
)