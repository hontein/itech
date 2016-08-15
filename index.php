<?php
include_once "AuthClass.php";
include "list.php";

$auth = new AuthClass();
if (isset($_POST["login"]) && isset($_POST["password"])) { //If username and password were sent
    if ($r = $auth->auth($_POST["login"], $_POST["password"])) {
        echo "<script>window.onload = function(){document.getElementById('error_msg_login').innerHTML ='" . $text[$r] . "';}</script>";
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
    echo "<div align='right'>Здравствуйте, " . $auth->getLogin();
    echo "<br/><br/><a href=\"panel.php?kartoteka=1\">Панель управления</a>"; //Show the escape button
    echo "<br/><br/><a href=\"?is_exit=1\">Выйти</a></div>";
} else { //If not authorized , showing the shape of a login and password
    ?>
    <div align="right"><h2>Авторизация на сайте:</h2>

        <form action="" method="post">
            <table>
                <tr>
                    <td>(test)Логин:</td>
                    <td><input type="text" name="login"
                               value="<?php echo (isset($_POST["login"])) ? $_POST["login"] : null; // Fill in the field by default ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>(test)Пароль:</td>
                    <td><input type="password" name="password" value=""/>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td align="right"><input type="submit" name="Войти"></td>
                </tr>
            </table>
        </form>
        <div id="error_msg_login" style="color: red">&nbsp;</div>
    </div>

<?php } ?>
<hr>
<div align="center"><h2>Поиск книг на сайте:</h2>
    <form method="post" action="">
        <table>
            <tr>
                <td>
                    Наименование книги:
                </td>
                <td><input type="text" name="name_book"
                           value="<?php echo (isset($_POST["name_book"])) ? $_POST["name_book"] : null; // Fill in the field by default ?>"/>
                </td>
            </tr>
            <tr>
                <td>Автор:</td>
                <td><input type="text" name="author" value=""/></td>
            </tr>

            <tr>
                <td></td>
                <td align="right"><input type="submit" value="Найти"/>
            </tr>
        </table>
    </form>
</div>

<?php
if (isset($_POST["name_book"]) or isset($_POST["author"])) {
    $db = new MysqlClass(SERVER, USER, PASS, DBNAME);
    $temp = "author INNER JOIN records ON author.id_author = records.id_author LEFT JOIN books ON records.id_book = books.id_book WHERE author.name LIKE '%" . $_POST["author"] .
        "%' AND books.name LIKE '%" . $_POST["name_book"] . "%'";
    if ($q = $db->select("author.name AS 'author', books.name AS 'name'", $temp)) {


        ?>
        <table border="1">
        <tr>
            <td>Автор</td>
            <td>Название</td>
        </tr>

        <?php
        foreach ($q AS $value) {
            ?>
            <tr>
                <td><?= $value['author'] ?></td>
                <td><?= $value['name'] ?></td>
            </tr>

        <?php }
        ?>  </table><?php
    } else {
        echo "<div>Книги не найдены </div>";
    } ?>
    <?php


}
?>
