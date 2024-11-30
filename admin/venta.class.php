<?php
// require_once ('../sistema.class.php');
require_once(__DIR__ . '/../sistema.class.php');

class venta extends sistema {
    function create($data) {
        $this->conexion();
        $this->con->beginTransaction();
        try {
            if (empty($data['fecha_venta'])) {
                $sql = "INSERT INTO venta(usuario_id, producto_id, cantidad, monto) VALUES(:usuario_id, :producto_id, :cantidad, :monto);";
                $stmt = $this->con->prepare($sql);
            } else {
                $sql = "INSERT INTO venta(usuario_id, producto_id, cantidad, monto, fecha_venta) VALUES(:usuario_id, :producto_id, :cantidad, :monto, :fecha_venta);";
                $stmt = $this->con->prepare($sql);
                $stmt->bindParam(':fecha_venta', $data['fecha_venta'], PDO::PARAM_STR);
            }
            $stmt->bindParam(':usuario_id', $data['usuario_id'], PDO::PARAM_INT);
            $stmt->bindParam(':producto_id', $data['producto_id'], PDO::PARAM_INT);
            $stmt->bindParam(':cantidad', $data['cantidad'], PDO::PARAM_INT);
            $stmt->bindParam(':monto', $data['monto'], PDO::PARAM_INT);
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
                if (empty($data['fecha_venta'])) {
                    $sql = "UPDATE venta SET usuario_id=:usuario_id, producto_id=:producto_id, cantidad=:cantidad, monto=:monto WHERE id=:id;";
                    $stmt = $this->con->prepare($sql);
                } else {
                    $sql = "UPDATE venta SET usuario_id=:usuario_id, producto_id=:producto_id, cantidad=:cantidad, monto=:monto, fecha_venta=:fecha_venta WHERE id=:id;";
                    $stmt = $this->con->prepare($sql);
                    $stmt->bindParam(':fecha_venta', $data['fecha_venta'], PDO::PARAM_STR);
                }
                $stmt->bindParam(':usuario_id', $data['usuario_id'], PDO::PARAM_INT);
                $stmt->bindParam(':producto_id', $data['producto_id'], PDO::PARAM_INT);
                $stmt->bindParam(':cantidad', $data['cantidad'], PDO::PARAM_INT);
                $stmt->bindParam(':monto', $data['monto'], PDO::PARAM_INT);
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