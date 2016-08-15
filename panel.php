<?php
include_once "menu.php";
$db = new MysqlClass(SERVER, USER, PASS, DBNAME);
if (isset($_GET['delete_record'])) {
    $db->delete("records", "id_record = " . $_GET['delete_record']);
}

if (isset($_GET['delete_author'])) {
    $db->delete("author", "id_author = " . $_GET['delete_author']);
    $db->delete("records", "id_author = " . $_GET['delete_author']);
}
if (isset($_GET['delete_book'])) {
    $db->delete("books", "id_book = " . $_GET['delete_book']);
    $db->delete("records", "id_book = " . $_GET['delete_book']);
}

if (isset($_GET['kartoteka'])) {
    ?>
    <div id="kartoteka">
        <h2>Список книг:</h2>
        <a href="new.php?new_record=1">NEW record</a>
        <?php

        $temp = "author INNER JOIN records ON author.id_author = records.id_author LEFT JOIN books ON records.id_book = books.id_book";
        if ($q = $db->select("author.name AS 'author', books.name AS 'name', records.id_record AS id", $temp)) {


            ?>

            <table border="1">
            <tr>
                <td>ID</td>
                <td>Автор</td>
                <td>Название</td>
                <td colspan="2"></td>
            </tr>

            <?php
            foreach ($q AS $value) {
                ?>
                <tr>
                    <td><?= $value['id'] ?></td>
                    <td><?= $value['author'] ?></td>
                    <td><?= $value['name'] ?></td>
                    <td>  <a href="edit.php?edit_record=<?= $value['id'] ?>">Edit</a></td>
                    <td><a href="?kartoteka=1&delete_record=<?= $value['id'] ?>">Delete</a></td>
                </tr>

            <?php }
            ?>  </table><?php
        } else {
            echo "<div>Книги не найдены </div>";
        } ?>
    </div>
    <?php
}
if (isset($_GET['author_list'])) {
    ?>
    <div id="author_list"><h2>Авторы</h2>
        <a href="new.php?new_author=1">NEW author</a>
        <?php
        if ($q = $db->select("id_author, name", "author")) {
            ?>

            <table border="1">
                <tr>
                    <td>ID</td>
                    <td>Автор</td>
                    <td colspan="2"></td>
                </tr>

                <?php
                foreach ($q AS $value) {
                    ?>
                    <tr>
                        <td><?= $value['id_author'] ?></td>
                        <td><?= $value['name'] ?></td>
                        <td><a href="edit.php?edit_author=<?= $value['id_author'] ?>">Edit</a></td>
                        <td><a href="?author_list=1&delete_author=<?= $value['id_author'] ?>">Delete</a></td>
                    </tr>

                <?php }
                ?>  </table>
            <?php
        } else {
            echo "<div>Авторы не найдены </div>";
        } ?>
    </div>
    <?php

}

if (isset($_GET['book_list'])) { ?>
    <div id="book_list"><h2>Книги</h2>
        <a href="new.php?new_book=1">NEW book</a>
        <?php
        if ($q = $db->select("id_book, name", "books")) {
            ?>

            <table border="1">
                <tr>
                    <td>ID</td>
                    <td>Наименование</td>
                    <td colspan="2"></td>
                </tr>

                <?php
                foreach ($q AS $value) {
                    ?>
                    <tr>
                        <td><?= $value['id_book'] ?></td>
                        <td><?= $value['name'] ?></td>
                        <td><a href="edit.php?edit_book=<?= $value['id_book'] ?>">Edit</a></td>
                        <td><a href="?book_list=1&delete_book=<?= $value['id_book'] ?>">Delete</a></td>
                    </tr>

                <?php }
                ?>  </table>
            <?php
        } else {
            echo "<div>Книги не найдены </div>";
        } ?>
    </div>
    <?php
} ?>