<?php


class BaseClass
{
    /**
     * Validation string
     * Return false if string not correct
     * @return boolean
     */
    protected function check($str)
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
}