<?php

include_once "menu.php";

$db = new MysqlClass(SERVER, USER, PASS, DBNAME);
if (isset($_GET['add_book'])) {
    if ($db->insert('books', array("", $_GET['add_book']))) {
        echo "Новая книга добавлена";
    }
}

if (isset($_GET['add_rec_book']) and isset($_GET['add_rec_author'])) {
    if ($db->insert('records', array("", $_GET['add_rec_book'], $_GET['add_rec_author']))) {
        echo "Новый автор добавлен";
    }
}
if (isset($_GET['add_author'])) {
    if ($db->insert('author', array("", $_GET['add_author']))) {
        echo "Новый автор добавлен";
    }

}

if (isset($_GET['add_record'])) {
    if ($db->insert('records', array("", $_GET['add_record']))) {
        echo "Новая книга добавлена в картотеку";
    }
}

if (isset($_GET['new_book'])) {
    ?>
    <h2>Новая книга</h2>
    <form action="" method="get">
        Название <input type="text" name="add_book" value="">
        <input type="hidden" name="new_book" value="1">
        <input type="submit" value="Создать">
    </form>
    <?php
}

if (isset($_GET['new_author'])) {
    ?>
    <h2>Новый автор</h2>
    <form action="" method="get">
        ФИО <input type="text" name="add_author" value="">
        <input type="hidden" name="new_author" value="1">
        <input type="submit" value="Создать">
    </form>
    <?php
}
if (isset($_GET['new_record'])) {

    ?>
    <h2>Добавить в картотеку</h2>
    <form action="" method="get">
        <select size="6" multiple name="add_rec_author">
            <option disabled>Авторы</option>
            <?php
            if ($q = $db->select("id_author, name", "author")) {
                foreach ($q as $item) {
                    echo " <option value = " . $item['id_author'] . ">" . $item['name'] . "</option>";
                }

            }
            ?>


        </select>
        <select size="6" multiple name="add_rec_book">
            <option disabled>Книги</option>
            <?php
            if ($q = $db->select("id_book, name", "books")) {
                foreach ($q as $item) {
                    echo " <option value = " . $item['id_book'] . ">" . $item['name'] . "</option>";
                }

            }
            ?>


        </select>
        <input type="hidden" name="new_record" value="1">
        <br>
        <input type="submit" value="Создать">
    </form>
    <?php
}
?>