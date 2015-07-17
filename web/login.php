<?php

//
use josegonzalez\Dotenv\Loader as Dotenv;

require '../vendor/autoload.php';

if (session_status() !== PHP_SESSION_ACTIVE) 
    session_start();

/**
 * alternatively, Dotenv::load(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env');
 */
Dotenv::load([
    'filepath' => dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env',
    'toEnv' => true,
]);

$auth_factory = new \Aura\Auth\AuthFactory($_COOKIE);
$auth = $auth_factory->newInstance();
//

//
$pdo = new \PDO($_ENV['DB_DSN'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
$cols = array(
    'username', // "AS username" is added by the adapter
    'password', // "AS password" is added by the adapter
    'email',
    'fullname',
    'website'
);
$from = 'users';
$where = 'active = 1';

$hash = new \Aura\Auth\Verifier\PasswordVerifier(PASSWORD_DEFAULT);

$pdo_adapter = $auth_factory->newPdoAdapter($pdo, $hash, $cols, $from, $where);
// 

$login_service = $auth_factory->newLoginService($pdo_adapter);

try {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $login_service->login($auth, array(
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            )
        );    
        $auth->setUserName($_POST['username']);
    }


} catch (\Aura\Auth\Exception\UsernameMissing $e) {
    echo "The 'username' field is missing or empty.";
} catch (\Aura\Auth\Exception\PasswordMissing $e) {
    echo "The 'password' field is missing or empty.";
} catch (\Aura\Auth\Exception\UsernameNotFound $e) {
    echo "The username you entered was not found.";
} catch (\Aura\Auth\Exception\MultipleMatches $e) {
    echo "There is more than one account with that username.";
} catch (\Aura\Auth\Exception\PasswordIncorrect $e) {
    echo "The password you entered was incorrect.";
} catch (\Aura\Auth\Exception\ConnectionFailed $e) {
    echo "Cound not connect to IMAP or LDAP server.";
    echo "This could be because the username or password was wrong,";
    echo "or because the the connect operation itself failed in some way. ";
    echo $e->getMessage();
} catch (\Aura\Auth\Exception\BindFailed $e) {
    echo "Cound not bind to LDAP server.";
    echo "This could be because the username or password was wrong,";
    echo "or because the the bind operations itself failed in some way. ";
    echo $e->getMessage();
}
if ($auth->isValid()) {
    echo "You are now logged into a new session. Check next.php";

    echo $auth->getUserName();
} else {

?>
<form method="post" enctype="multipart/form-data">
  <label>User name : <input type="text" name="username" placeholder="harikt"/></label>
  <label>Password : <input type="password" name="password" placeholder="123456"/></label>
  <input type="submit" value="login" />
</form>
<?php
}
?>
