<?php
require_once ('../sistema.class.php');

class venta extends sistema {
    function create($data) {
        $this->conexion();
        $this->con->beginTransaction();
        try {
            $sql = "INSERT INTO venta(usuario_id, producto_id, cantidad) VALUES(:usuario_id, :producto_id, :cantidad);";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':usuario_id', $data['usuario_id'], PDO::PARAM_INT);
            $stmt->bindParam(':producto_id', $data['producto_id'], PDO::PARAM_INT);
            $stmt->bindParam(':cantidad', $data['cantidad'], PDO::PARAM_INT);
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
                $sql = "UPDATE venta SET usuario_id=:usuario_id, producto_id=:producto_id, cantidad=:cantidad WHERE id=:id;";
                $stmt = $this->con->prepare($sql);
                $stmt->bindParam(':usuario_id', $data['usuario_id'], PDO::PARAM_INT);
                $stmt->bindParam(':producto_id', $data['producto_id'], PDO::PARAM_INT);
                $stmt->bindParam(':cantidad', $data['cantidad'], PDO::PARAM_INT);
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
                $sql = "DELETE FROM venta WHERE id=:id;";
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
            $sql = "SELECT * FROM venta WHERE id=:id;";
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
            $sql = "SELECT v.*, u.nombre_completo, p.nombre_producto FROM venta v INNER JOIN usuario u ON v.usuario_id = u.id INNER JOIN producto p ON v.producto_id = p.id;";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error en readAll: " . $e->getMessage());
        }
    }
}
?>