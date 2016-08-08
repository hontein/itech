<?php
session_start();

/**
 * Authorization class
 * @author Roman Morozov <mrm1989@mail.ru>
 */
class AuthClass
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
     */
    public function auth($login, $passwors)
    {
        if (!$this->check($login)) {
            return "error_login";
        }
        if (!$this->check($passwors)) {
            return "error_password";
        }
        $_SESSION["is_auth"] = true; //Делаем пользователя авторизованным
        $_SESSION["login"] = $login; //Записываем в сессию логин пользователя
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
     * Validation string
     * Return false if string not correct
     * @return boolean
     */
    private function check($str)
    {
        $temp = $str;
        $temp = trim($temp);
        $temp = htmlspecialchars($temp);
        $temp = strip_tags($temp);
        if ($temp == $str)
            return true;
        else
            return false;
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