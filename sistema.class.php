<?php
    session_start();
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
                $data = $roles -> fetchAll(PDO::FETCH_ASSOC);
                $roles = [];

                foreach($data as $rol) {
                    array_push($roles, $rol['rol']);
                }

                $data = $roles;
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
                $permisos = [];

                foreach($data as $permiso) {
                    array_push($permisos, $permiso['permiso']);
                }

                $data = $permisos;
            }
            
            return $data;
        }

        function login($email, $contrasena) {
            $contrasena = md5($contrasena);
            $acceso = false;
  
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $this -> conexion();
              $sql = "select * from usuario where email = :email and contrasena = :contrasena;";
              $sql = $this->con->prepare($sql);
              $sql->bindParam(":email",$email,PDO::PARAM_STR);
              $sql->bindParam(":contrasena",$contrasena,PDO::PARAM_STR);
              $sql->execute();
              $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
  
              if (isset($resultado[0])) {
                $acceso = true;
                $_SESSION['email'] = $email;
                $_SESSION['validado'] = $acceso;
                $roles = $this -> getRole($email);
                $privilegios = $this -> getPrivilegios($email);
  
                $_SESSION['roles'] = $roles;
                $_SESSION['privilegios'] = $privilegios;
  
                return $acceso;
              }
            }
  
            $_SESSION['validado'] = false;
            return $acceso;
        }
  
        function logout() {
            unset($_SESSION);
            session_destroy();
            $mensaje = "Gracias por utilizar el sistema, se ha cerrado la sesion <a href='login.php'> [presione aqui para volver a entrar] </a>";
            $tipo = "success";
            require_once('views/header.php');
            $this -> alerta($tipo, $mensaje);
            require_once('views/footer.php');
        }

        function checkRole($rol) {
            if (isset($_SESSION['roles'])) {
              $roles = $_SESSION['roles'];
              if (!in_array($rol, $roles)) {
                $mensaje = "Requiere iniciar sesion <a href='login.php'>[iniciar sesion]</a>";
                $tipo = "danger";
                require_once('admin/views/header/alert.php');
                $this -> alerta($tipo, $mensaje);
                die();
              } else { }
            } else {
              $mensaje = "Requiere iniciar sesion <a href='login.php'>[iniciar sesion]</a>";
              $tipo = "danger";
              $this -> alerta($tipo, $mensaje);
              die();
            }
        }
    }
?>
