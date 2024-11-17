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
            return $stmt->rowCount();
        } catch (Exception $e) {
            $this->con->rollBack();
            throw new Exception("Error en create: " . $e->getMessage());
        }
    }

    function update($id, $data) {
        $this->conexion();
        $this->con->beginTransaction();
        try {
            if (is_numeric($id)) {
                $sql = "UPDATE recompensa SET usuario_id=:usuario_id, descripcion=:descripcion, fecha_otorgada=:fecha_otorgada WHERE id=:id;";
                $stmt = $this->con->prepare($sql);
                $stmt->bindParam(':usuario_id', $data['usuario_id'], PDO::PARAM_STR);
                $stmt->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
                $stmt->bindParam(':fecha_otorgada', $data['fecha_otorgada'], PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $this->con->commit();
                return $stmt->rowCount();
            } else {
                throw new Exception("ID no válido.");
            }
        } catch (Exception $e) {
            $this->con->rollBack();
            throw new Exception("Error en update: " . $e->getMessage());
        }
    }

    function delete($id) {
        $this->conexion();
        $this->con->beginTransaction();
        try {
            if (is_numeric($id)) {
                $sql = "DELETE FROM recompensa WHERE id=:id;";
                $stmt = $this->con->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $this->con->commit();
                return $stmt->rowCount();
            } else {
                throw new Exception("ID no válido.");
            }
        } catch (Exception $e) {
            $this->con->rollBack();
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
}
?>