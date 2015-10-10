<?php

function createDefaultDatabase() {
    $pdo = \defaultTodoPdo();
    $createTable = $pdo->exec('
    CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(255) NOT NULL COMMENT "Username",
        `email` varchar(255) NOT NULL COMMENT "Email",
        `password` varchar(255) NOT NULL COMMENT "Password",
        `fullname` varchar(255) NOT NULL COMMENT "Full name",
        `website` varchar(255) DEFAULT NULL COMMENT "Website",
        `active` int(11) NOT NULL COMMENT "0",

        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
      INSERT INTO `users` (`id`, `username`, `email`, `password`, `fullname`, `website`, `active`) VALUES
      (1, "harikt", "hello@example.com",  "$2y$10$PAzgJnHd/gTQzNznVg7un.HGEuGHYtYACCFknGuf.4diSunu3MA7C", "Hari KT",  "http://harikt.com", 1),
      (2, "pmjones",  "hello@example.com",  "$2y$10$vtW.Fu8fhWuuCZz6s/jus.ilkzOMjMGwbzdkZNUzIVZLc.PV/6dVG", "Paul M Jones", "http://paul-m-jones.com",  1);
    ');    

    $createTable = $pdo->exec('
      CREATE TABLE IF NOT EXISTS `todo` (
        `todoId` int(11) NOT NULL AUTO_INCREMENT,
        `description` varchar(255) NOT NULL COMMENT "String description of this Todo",
        `userId` int(11) DEFAULT NULL COMMENT "Id of the User connected to this Todo",
        PRIMARY KEY (`todoId`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ');     
}