<?php

class Validaciones{
    public static function validarStrings($str){
        return preg_match('/^[A-Za-z0-9,\s]+$/', $str);     //devuelve false en caso de que el string no sea valido (contenga solo letras, signos de puntuacion o numeros)
    }
    
    public static function validarInt($int){
        return preg_match('/^\d+$/', $int);             // ^ indica que comienza y $ termina con el mismo caracter \d que representa a numeros. devuelve true si es valido
    }
}


?>