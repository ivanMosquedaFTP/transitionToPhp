<?php
require_once ('../sistema.class.php');

class recompensa extends sistema {
    function create($data) {
        $this->conexion();
        $this->con->beginTransaction();
        try {
            $sql = "INSERT INTO recompensa(usuario_id, descripcion) VALUES(:usuario_id, :descripcion);";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':usuario_id', $data['usuario_id'], PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
            $stmt->execute();
            $this->con->commit();

            $userEmail = $this->getUserEmail($data['usuario_id']);
            $userName = $this->getUserName($data['usuario_id']);

            if (!empty($userEmail) && isset($userEmail[0]['email']) && !empty($userName)) {
                $email = $userEmail[0]['email'];
                $nombreUsuario = $userName['nombre_completo'];
                $detalleRecompensa = $data['descripcion'];

                $this->sendRecompensaAknowledgeEmail($email, $nombreUsuario, $detalleRecompensa);
            }

            return $stmt->rowCount();
        } catch (Exception $e) {
            $this->con->rollBack();
            throw new Exception("Error en create: " . $e->getMessage());
        }
    }

    function update($id, $data) {
        $this->conexion();
        try {
            if (is_numeric($id)) {
                $recompensaAnterior = $this->readOne($id);
    
                if ($recompensaAnterior) {
                    $this->con->beginTransaction();
    
                    $sql = "UPDATE recompensa 
                            SET usuario_id = :usuario_id, descripcion = :descripcion, fecha_otorgada = :fecha_otorgada 
                            WHERE id = :id;";
                    $stmt = $this->con->prepare($sql);
                    $stmt->bindParam(':usuario_id', $data['usuario_id'], PDO::PARAM_INT);
                    $stmt->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
                    $stmt->bindParam(':fecha_otorgada', $data['fecha_otorgada'], PDO::PARAM_STR);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $this->con->commit();
    
                    $userEmail = $this->getUserEmail($data['usuario_id']);
                    $userName = $this->getUserName($data['usuario_id']);
    
                    if (!empty($userEmail) && isset($userEmail[0]['email']) && !empty($userName)) {
                        $email = $userEmail[0]['email'];
                        $nombreUsuario = $userName['nombre_completo'];
                        $detalleRecompensa = $data['descripcion'];
    
                        $this->sendRecompensaUpdateEmail($email, $nombreUsuario, $detalleRecompensa);
                    }
    
                    return $stmt->rowCount();
                } else {
                    throw new Exception("La recompensa no existe.");
                }
            } else {
                throw new Exception("ID no válido.");
            }
        } catch (Exception $e) {
            if ($this->con->inTransaction()) {
                $this->con->rollBack();
            }
            throw new Exception("Error en update: " . $e->getMessage());
        }
    }

    function delete($id) {
        $this->conexion();
        try {
            if (is_numeric($id)) {
                $recompensa = $this->readOne($id);
                if ($recompensa) {
                    $usuarioId = $recompensa['usuario_id'];
                    $detalleRecompensa = $recompensa['descripcion'];
    
                    $this->con->beginTransaction();
                    $sql = "DELETE FROM recompensa WHERE id=:id;";
                    $stmt = $this->con->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $this->con->commit();
    
                    $userEmail = $this->getUserEmail($usuarioId);
                    $userName = $this->getUserName($usuarioId);
    
                    if (!empty($userEmail) && isset($userEmail[0]['email']) && !empty($userName)) {
                        $email = $userEmail[0]['email'];
                        $nombreUsuario = $userName['nombre_completo'];
    
                        $this->sendRecompensaRemovalEmail($email, $nombreUsuario, $detalleRecompensa);
                    }
                }
    
                return $stmt->rowCount();
            } else {
                throw new Exception("ID no válido.");
            }
        } catch (Exception $e) {
            if ($this->con->inTransaction()) {
                $this->con->rollBack();
            }
            throw new Exception("Error en delete: " . $e->getMessage());
        }
    }
    

    function readOne($id) {
        $this->conexion();
        try {
            $sql = "SELECT * FROM recompensa WHERE id=:id;";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error en readOne: " . $e->getMessage());
        }
    }

    function readAll() {
        $this->conexion();
        try {
            $sql = "SELECT r.*, u.nombre_completo FROM recompensa r INNER JOIN usuario u ON r.usuario_id = u.id;";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error en readAll: " . $e->getMessage());
        }
    }

    function getUserEmail($id) {
        $this->conexion();
        $this -> con -> beginTransaction();

        try {
            $sql = "select u.email as email from usuario u inner join recompensa r on u.id=r.usuario_id where r.usuario_id = :id;";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $this -> con -> commit();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this -> con -> rollBack();
            throw new Exception("El usuario especificado no existe". $e->getMessage());
        }

        return false;
    }

    function getUserName($id) {
        $this->conexion();
        try {
            $sql = "SELECT u.nombre_completo AS nombre_completo FROM usuario u inner join recompensa r on u.id=r.usuario_id WHERE u.id = :id;";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error al obtener el nombre del usuario: " . $e->getMessage());
        }
    }
}
?>