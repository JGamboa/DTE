<?php
require_once('Constantes.php');
require_once('MysqliDb.php');
require_once ("dbObject.php");

$db = new MysqliDb (Array (
                'host' => Constantes::DB_HOST,
                'username' => Constantes::DB_USERNAME, 
                'password' => Constantes::DB_PASSWORD,
                'db'=> Constantes::DB_NAME,
                'port' => 3306,
                'charset'=>'latin1'));

