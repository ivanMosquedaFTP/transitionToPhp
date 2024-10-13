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

        function getRole($email) {
            $this -> conexion();
            $data = [];
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $sql = "select r.rol from usuario u inner join usuario_rol ur on u.id = ur.id_usuario
                    inner JOIN rol r on r.id_rol = ur.id_rol
                    where u.email = :email ";

                $roles = $this->con->prepare($sql);
                $roles->bindParam(":email",$email,PDO::PARAM_STR);
                $roles->execute();
                $data = $roles->fetchAll(PDO::FETCH_ASSOC);
            }
            
            return $data;
        }

        function getPrivilegios($email) {
            $this -> conexion();
            $data = [];
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $sql = "select p.permiso from usuario u inner join usuario_rol ur on u.id = ur.id_usuario
                        inner JOIN rol r on r.id_rol = ur.id_rol
                        INNER JOIN rol_permiso rp on rp.id_rol = r.id_rol
                        inner JOIN permiso p on p.id_permiso = rp.id_permiso
                            where u.email = :email;";

                $privilegio = $this->con->prepare($sql);
                $privilegio->bindParam(":email",$email,PDO::PARAM_STR);
                $privilegio->execute();
                $data = $privilegio->fetchAll(PDO::FETCH_ASSOC);
            }
            
            return $data;
        }
    }
?>
