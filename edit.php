<?php
include_once "menu.php";

$db = new MysqlClass(SERVER, USER, PASS, DBNAME);
if (isset($_GET['upd_book'])) {
    if ($db->update('books', array('name' => $_GET['upd_book']), array('id_book', $_GET['edit_book']), "="))
        echo "Запись изменена";
}

if (isset($_GET['upd_author'])) {
    if ($db->update('author', array('name' => $_GET['upd_author']), array('id_author', $_GET['edit_author']), "="))
        echo "Запись изменена";
}

if (isset($_GET['upd_rec_book']) and isset($_GET['upd_rec_author'])) {
    if ($db->update('records', array('id_book' => $_GET['upd_rec_book'],'id_author' => $_GET['upd_rec_author']), array('id_record', $_GET['edit_record']), "="))
        echo "Запись изменена";
}
if (isset($_GET['edit_book'])) {
    $q = $db->select("id_book, name", "books", "id_book=" . $_GET['edit_book']);

    ?>
    <h2>Изменение книги</h2>
    <form action="" method="get">
        Название <input type="text" name="upd_book" value="<?= $q[0]['name'] ?>">
        <input type="hidden" name="edit_book" value="<?= $_GET['edit_book'] ?>">
        <input type="submit" value="Изменить">
    </form>
    <?php
}



if (isset($_GET['edit_author'])) {
    $q = $db->select("id_author, name", "author", "id_author=" . $_GET['edit_author']);
    ?>
    <h2>Изменение автора</h2>
    <form action="" method="get">
        ФИО <input type="text" name="upd_author" value="<?= $q[0]['name'] ?>">
        <input type="hidden" name="edit_author" value="<?= $_GET['edit_author'] ?>">
        <input type="submit" value="Изменить">
    </form>
    <?php
}
if (isset($_GET['edit_record'])) {
    ?>
    <h2>Изменение в картотеке</h2>
    <form action="" method="get">
        <?php
        if ($temp = $db->select("id_author, id_book", "records", "id_record=" . $_GET['edit_record'])) {
            ?>

            <select size="6" multiple name="upd_rec_author">
                <option disabled>Авторы</option>
                <?php
                if ($q = $db->select("id_author, name", "author")) {
                    foreach ($q as $item) {
                        if ($temp[0]['id_author'] == $item['id_author'])
                            echo " <option  selected value = " . $item['id_author'] . ">" . $item['name'] . "</option>";
                        else {
                            echo " <option   value = " . $item['id_author'] . ">" . $item['name'] . "</option>";
                        }
                    }

                }
                ?>


            </select>
            <select size="6" multiple name="upd_rec_book">
                <option disabled>Книги</option>
                <?php
                if ($q = $db->select("id_book, name", "books")) {
                    foreach ($q as $item) {
                        if ($temp[0]['id_book'] == $item['id_book'])
                            echo " <option  selected value = " . $item['id_book'] . ">" . $item['name'] . "</option>";
                        else {
                            echo " <option value = " . $item['id_book'] . ">" . $item['name'] . "</option>";
                        }
                    }

                }
                ?>


            </select>
            <input type="hidden" name="edit_record" value=<?=$_GET['edit_record']?>>

            <br>
            <input type="submit" value="Изменить">
        <?php } ?>
    </form>

    <?php
}