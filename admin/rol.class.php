<?php
require_once ('../sistema.class.php');

class rol extends sistema {
    function create($data) {
        $this->conexion();
        $this->con->beginTransaction();
        try {
            $sql = "INSERT INTO rol(rol) VALUES(:rol);";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':rol', $data['rol'], PDO::PARAM_STR);
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
            $sql = "UPDATE rol SET rol=:rol WHERE id_rol=:id_rol;";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id_rol', $id, PDO::PARAM_INT);
            $stmt->bindParam(':rol', $data['rol'], PDO::PARAM_STR);
            $stmt->execute();
            $this->con->commit();
            return $stmt->rowCount();
        } catch (Exception $e) {
            $this->con->rollBack();
            throw new Exception("Error en update: " . $e->getMessage());
        }
    }

    function delete($id) {
        $this->conexion();
        $this->con->beginTransaction();
        try {
            $sql = "DELETE FROM rol WHERE id_rol=:id_rol;";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id_rol', $id, PDO::PARAM_INT);
            $stmt->execute();
            $this->con->commit();
            return $stmt->rowCount();
        } catch (Exception $e) {
            $this->con->rollBack();
            throw new Exception("Error en delete: " . $e->getMessage());
        }
    }

    function readOne($id) {
        $this->conexion();
        try {
            $sql = "SELECT * FROM rol WHERE id_rol=:id_rol;";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(":id_rol", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error en readOne: " . $e->getMessage());
        }
    }

    function readAll() {
        $this->conexion();
        try {
            $sql = "SELECT * FROM rol;";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error en readAll: " . $e->getMessage());
        }
    }
}
?>