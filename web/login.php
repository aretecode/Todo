<?php

//
use josegonzalez\Dotenv\Loader as Dotenv;

require '../vendor/autoload.php';

startSession();
loadDotEnv(__DIR__);

$authFactory = new \Aura\Auth\AuthFactory($_COOKIE);
$auth = $authFactory->newInstance();
//

//
$pdo = \defaultTodoPdo();
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

$pdoAdapter = $authFactory->newPdoAdapter($pdo, $hash, $cols, $from, $where);
// 

$loginService = $authFactory->newLoginService($pdoAdapter);

try {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $loginService->login($auth, array(
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
