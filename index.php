<?php
include_once "AuthClass.php";
include "list.php";

$auth = new AuthClass();
if (isset($_POST["login"]) && isset($_POST["password"])) { //If username and password were sent
    if ($r = $auth->auth($_POST["login"], $_POST["password"])) {
        echo $text[$r];
    }
}

if (isset($_GET["is_exit"])) { //If you press the exit button
    if ($_GET["is_exit"] == 1) {
        $auth->out(); //exit
        header("Location: ?is_exit=0"); //Redirect after
    }
}
?>

<?php if ($auth->isAuth()) { // If the user is logged in, welcome :
    echo "Здравствуйте, " . $auth->getLogin();
    echo "<br/><br/><a href=\"?is_exit=1\">Выйти</a>"; //Show the escape button
} else { //If not authorized , showing the shape of a login and password
    ?>
    <form method="post" action="">
        Логин: <input type="text" name="login"
                      value="<?php echo (isset($_POST["login"])) ? $_POST["login"] : null; // Fill in the field by default ?>"/><br/>
        Пароль: <input type="password" name="password" value=""/><br/>
        <input type="submit" value="Войти"/>
    </form>
<?php } ?>