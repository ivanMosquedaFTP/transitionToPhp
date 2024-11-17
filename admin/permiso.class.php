<?php
require_once ('../sistema.class.php');

class permiso extends sistema {
    function create($data) {
        $this->conexion();
        $this->con->beginTransaction();
        try {
            $sql = "INSERT INTO permiso(permiso) VALUES(:permiso);";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':permiso', $data['permiso'], PDO::PARAM_STR);
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
            $sql = "UPDATE permiso SET permiso=:permiso WHERE id_permiso=:id_permiso;";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id_permiso', $id, PDO::PARAM_INT);
            $stmt->bindParam(':permiso', $data['permiso'], PDO::PARAM_STR);
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
            $sql = "DELETE FROM permiso WHERE id_permiso=:id_permiso;";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id_permiso', $id, PDO::PARAM_INT);
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
        $sql = "SELECT * FROM permiso WHERE id_permiso=:id_permiso;";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(":id_permiso", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function readAll() {
        $this->conexion();
        $sql = "SELECT * FROM permiso;";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>