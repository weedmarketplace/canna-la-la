<?php
if (!function_exists('rplUC')) {
    function rplUC($string)
    {
        $string = str_replace('_', ' ', $string);
        $string = ucwords($string);
        return $string;
    }
}