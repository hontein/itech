<?php
include_once "AuthClass.php";

$auth = new AuthClass();
if (!$auth->isAuth()) {
    return 0;
}
echo "<div align='right'>Здравствуйте, " . $auth->getLogin();
echo "<br/><br/><a href=\"index.php\">Главная</a>"; //Show the escape button
echo "<br/><br/><a href=\"panel.php?author_list=1\">Список Авторов</a>"; //Show the escape button
echo "<br/><br/><a href=\"panel.php?book_list=1\">Список книг</a>"; //Show the escape button
echo "<br/><br/><a href=\"panel.php?kartoteka=1\">Картотека</a>"; //Show the escape button
echo "<br/><br/><a href=\"index.php?is_exit=1\">Выйти</a></div>";
