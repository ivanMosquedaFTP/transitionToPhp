<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
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

        function sendMail($destinatario, $asunto, $mensaje) {
            require 'vendor/autoload.php';
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->Username = '21031178@itcelaya.edu.mx';
            $mail->Password = 'hddtbkluglsvkokq';
            $mail->setFrom('21031178@itcelaya.edu.mx', 'CoolHats');
            $mail->addAddress($destinatario, 'Estimado cliente');
            $mail->Subject = $asunto;
            $mail->msgHTML($mensaje);
            $mail->AltBody = 'This is a plain-text message body';
  
            if (!$mail->send()) {
              echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
              echo 'Message sent!';
            }
        }

        function sendRecompensaAknowledgeEmail($destinatario, $nombreUsuario, $detalleRecompensa) {
            require 'vendor/autoload.php';
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->Username = '21031178@itcelaya.edu.mx';
            $mail->Password = 'hddtbkluglsvkokq';
            $mail->setFrom('21031178@itcelaya.edu.mx', 'CoolHats');
            $mail->CharSet = 'UTF-8';
        
            $asunto = "Felicitaciones ".$nombreUsuario." has obtenido una recompensa en CoolHats";
        
            $mensaje = "
                <h1>¡Felicidades ".$nombreUsuario."!</h1>
                <p>Te informamos que has obtenido la siguiente recompensa:</p>
                <p><strong>Recompensa: </strong>".$detalleRecompensa."</p>
                <p> Visitanos pronto para disfrutar de tus beneficios.</p>
                <p>Atentamente,<br>El equipo de CoolHats</p>
            ";
        
            $mail->addAddress($destinatario, $nombreUsuario);
            $mail->Subject = $asunto;
            $mail->msgHTML($mensaje);
            $mail->AltBody = strip_tags($mensaje);
        
            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message sent!';
            }
        }

        function sendRecompensaRemovalEmail($destinatario, $nombreUsuario, $detalleRecompensa) {
            require 'vendor/autoload.php';
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->Username = '21031178@itcelaya.edu.mx';
            $mail->Password = 'hddtbkluglsvkokq';
            $mail->setFrom('21031178@itcelaya.edu.mx', 'CoolHats');
            $mail->CharSet = 'UTF-8';
        
            $asunto = "Notificación: ".$nombreUsuario.", tu recompensa ha sido removida";
        
            $mensaje = "
                <h1>Hola ".$nombreUsuario.",</h1>
                <p>Te informamos que la siguiente recompensa ha sido removida de tu cuenta:</p>
                <p><strong>Recompensa: </strong>".$detalleRecompensa."</p>
                <p>Si tienes alguna duda o crees que esto es un error, no dudes en contactarnos.</p>
                <p>Atentamente,<br>El equipo de CoolHats</p>
            ";
        
            $mail->addAddress($destinatario, $nombreUsuario);
            $mail->Subject = $asunto;
            $mail->msgHTML($mensaje);
            $mail->AltBody = strip_tags($mensaje);
        
            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message sent!';
            }
        }

        function sendRecompensaUpdateEmail($destinatario, $nombreUsuario, $detalleRecompensa) {
            require 'vendor/autoload.php';
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->Username = '21031178@itcelaya.edu.mx';
            $mail->Password = 'hddtbkluglsvkokq';
            $mail->setFrom('21031178@itcelaya.edu.mx', 'CoolHats');
            $mail->CharSet = 'UTF-8';
        
            $asunto = "Actualización de recompensa en CoolHats";
        
            $mensaje = "
                <h1>Hola ".$nombreUsuario.",</h1>
                <p>Te informamos que tu recompensa ha sido actualizada con los siguientes detalles:</p>
                <p><strong>Nueva Descripción: </strong>".$detalleRecompensa."</p>
                <p>Gracias por ser parte de CoolHats. Visítanos para disfrutar de tus beneficios.</p>
                <p>Atentamente,<br>El equipo de CoolHats</p>
            ";
        
            $mail->addAddress($destinatario, $nombreUsuario);
            $mail->Subject = $asunto;
            $mail->msgHTML($mensaje);
            $mail->AltBody = strip_tags($mensaje);
        
            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message sent!';
            }
        }
    }
?>