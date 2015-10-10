# Todo
An experiment with [ADR](https://github.com/pmjones/adr)

[![Build Status](https://secure.travis-ci.org/aretecode/todo.svg)](https://travis-ci.org/aretecode/todo)

## Instructions 

1. Set DB in .env

2. Create the tables (using the following SQL)

  ```sql
  CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(255) NOT NULL COMMENT 'Username',
    `email` varchar(255) NOT NULL COMMENT 'Email',
    `password` varchar(255) NOT NULL COMMENT 'Password',
    `fullname` varchar(255) NOT NULL COMMENT 'Full name',
    `website` varchar(255) DEFAULT NULL COMMENT 'Website',
    `active` int(11) NOT NULL COMMENT '0',
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  INSERT INTO `users` (`id`, `username`, `email`, `password`, `fullname`, `website`, `active`) VALUES
  (1, 'harikt', 'hello@example.com',  '$2y$10$PAzgJnHd/gTQzNznVg7un.HGEuGHYtYACCFknGuf.4diSunu3MA7C', 'Hari KT',  'http://harikt.com', 1),
  (2, 'pmjones',  'hello@example.com',  '$2y$10$vtW.Fu8fhWuuCZz6s/jus.ilkzOMjMGwbzdkZNUzIVZLc.PV/6dVG', 'Paul M Jones', 'http://paul-m-jones.com',  1);
  ```
  ```sql
  CREATE TABLE `todo` (
    `todoId` int(11) NOT NULL AUTO_INCREMENT,
    `description` varchar(255) NOT NULL COMMENT 'String description of this Todo',
    `userId` int(11) DEFAULT NULL COMMENT 'Id of the User connected to this Todo',
    PRIMARY KEY (`todoId`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  ```

3. Change into the project directory (is `todo` here), then start the built-in PHP web server:
```
    cd todo
    php -S localhost:8080 -t web/
```

4. Browse to `<http://localhost:8080/todo/ajax.php>` to do some stuff with a GUI
 
5. You can browse to `<http://localhost:8080/add/words-of-the-todo-you-want-to-add>` or with other commands
> if using ajax, change the `var url = ` in [linkhere]

OR 

- Change into the project directory (is `todo` here) and go to `<http:\\your-todo-project/web/todo/add/words-of-the-todo-you-want-to-add>` 


## Questions: 
Should Parameters in Domain be (array), or individual?
> Whichever makes more sense for your domain

Why does EditItemInput not work?
> Unknown, debug with playing around with the $_SERVER

Add vs Create?
> Add makes more sense when using Views and with that View, reaching into the domain only for defaults

How to best test testGetListSuccess ? get results from db & compare? Regex compare just a bit of it?
> Current comparison is fine, think it is something with Zend

Does it compare Input instead of Output if it is a 404?
> Yes, but in Zend 

Why can't traits be set in Aura.Di config?

## @TODO: 
* [ ] AuthorizationService implementation.
* [x] ~~Fix User~~
* [x] ~~Add Login form for the authentication.~~
* [ ] Put it on a demo site so it can be played around with.
* [x] ~Make the aj(ax) example not just interpret other HTTP status codes as `error` but react respectively.
* [ ] Add Views
* [ ] Hotswap Responses
* [ ] getItemTest
* [ ] userTest
* [ ] Add proper uses of HTTP Methods (especially Put)

## Credits (uses)
- [Radar](https://github.com/radarphp/Radar.Adr/)
- [ADR](https://github.com/pmjones/adr)
- [AuraAuth example](https://github.com/harikt/authentication-pdo-example)