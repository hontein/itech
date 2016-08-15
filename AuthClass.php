<?php
session_start();
include_once "MysqlClass.php";
include_once "BaseClass.php";

/**
 * Authorization class
 * @author Roman Morozov <mrm1989@mail.ru>
 */
class AuthClass extends BaseClass
{

    /**
     * It verifies that the user is authorized or not
     * Returns true if authorized , false otherwise
     *
     * @return boolean
     */
    public function isAuth()
    {
        if (isset($_SESSION["is_auth"])) { // If the session exists
            return $_SESSION["is_auth"];// Return the value of the variable is_auth session ( holds true if authorized , false if not logged in )
        } else
            return false; // The user is not authorized , as is_auth variable has not been created
    }

    /**
     * Authorization
     * @param string $login
     * @param string $passwors
     * @return boolean
     */
    public function auth($login, $passwors)
    {
        if (!$this->check($login)) {
            return "error_login";
        }
        if (!$this->check($passwors)) {
            return "error_password";
        }
        $db = new MysqlClass(SERVER, USER, PASS, DBNAME);
        $q = $db->select("*", 'users', "username = '" . $login . "'");

        if (($q) && md5($passwors) == $q[0]['password']) {
            $_SESSION["is_auth"] = true; //Делаем пользователя авторизованным
            $_SESSION["login"] = $login; //Записываем в сессию логин пользователя
        }else{
            return "not_auth";
        }
        return false;
    }


    /**
     * The method returns an authorized user login
     * @return string
     */
    public function getLogin()
    {
        if ($this->isAuth()) { //If the user is authorized
            return $_SESSION["login"]; //Return the login name that is stored in session
        }
    }

    /**
     * Session destroy
     *
     */
    public function out()
    {
        $_SESSION = array(); //Clear the session
        session_destroy(); //destroy
    }
}