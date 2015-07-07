
## Instructions 

- Set DB in .env

- Create the tables (using the following SQL)

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

-  Change into the project directory (is `todo` here), then start the built-in PHP web server:
```
    cd todo
    php -S localhost:8080 -t web/
```

- Browse to <http://localhost:8080/todo/ajax.php> to do some stuff with a GUI

- You can also browse to <http://localhost:8080/add/words-of-the-todo-you-want-to-add> or with other commands

# Questions: 
- !!! How should User, Authentication, & Authorization be implemented?
    Should UserId be in the HTTTP Request & then use AppService and return a payload only if NOT_AUTHORIZED?

- Why does EditItemInput not work?

- Add vs Create?

- How to best test testGetListSuccess ? get results from db & compare? Regex compare just a bit of it?

- Does it compare Input instead of Output if it is a 404?

### Files with questions:
- Web\Responder\AbstractTodoResponder
- Web\Config

## @TODO: 
Make the aj(ax) example not just interpret other HTTP status codes as `error` but react respectively.

## Thank you 
I really appreciate your input, feel free to make it as long or as short as you would like. Thank you.
