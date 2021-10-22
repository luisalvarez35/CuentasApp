<?php

if(isset($_COOKIE["Visitas"]))
{
    $Cookie = $_COOKIE["Visitas"];
    setcookie('Visitas' ,$Cookie+1 , time() + 60 * 60 * 24 * 30);
}else
{
    $Cookie = 1;
    setcookie('Visitas', $Cookie, time() + 60 * 60 * 24 * 30);
}

if(isset($_COOKIE["Visitas"]))
{
    $contador = $_COOKIE["Visitas"];
}else

$_COOKIE["Visitas"] = "0";
?>
