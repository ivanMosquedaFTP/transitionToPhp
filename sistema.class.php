<?php
    require_once('config.class.php');
    class sistema {
        var $con;
        function conexion(){
            $this -> con = new PDO(SGBD.':host='.DBHOST.';dbname='.DBNAME.';port='.DBPORT, DBUSER, DBPASS);
        }
        
        function alerta($tipo, $mensaje) {
            include('views/alert.php');
        }
    }
?>