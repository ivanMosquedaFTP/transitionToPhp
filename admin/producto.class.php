<?php
 require_once ('../sistema.class.php');

 class producto extends sistema {
    function create ($data){
        $result = [];
        $insertar = [];
        $this -> conexion();
        $this -> con -> beginTransaction();

        try {
            $sql="insert into producto(nombre_producto, descripcion, precio, stock, foto) values(:nombre_producto, :descripcion, :precio, :stock, :foto);";
            $insertar = $this->con->prepare($sql);

            $foto = $this -> uploadFoto();

            $insertar -> bindParam(':nombre_producto', $data['nombre_producto'], PDO::PARAM_STR);
            $insertar -> bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
            $precio = strval($data['precio']);
            $insertar -> bindParam(':precio', $data['precio'], PDO::PARAM_STR);
            $insertar -> bindParam(':stock', $data['stock'], PDO::PARAM_INT);
            $insertar -> bindParam(':foto',$foto, PDO::PARAM_STR);
            $insertar -> execute();

            $this -> con -> commit();

            $result = $insertar -> rowCount();
            return $result;
        } catch (Exception $e) {
            $this -> con -> rollBack();
            echo''. $e -> getMessage() .'';
        }

        return false;
    }

    function update($id, $data) {
        $this->conexion();
        $this->con->beginTransaction();
        try {
            $sql = "UPDATE producto SET nombre_producto=:nombre_producto, descripcion=:descripcion, precio=:precio, stock=:stock, foto=:foto WHERE id=:id;";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':nombre_producto', $data['nombre_producto'], PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
            $precio = strval($data['precio']);
            $stmt->bindParam(':precio', $data['precio'], PDO::PARAM_STR);
            $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
            $stmt->bindParam(':foto', $data['foto'], PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $this->con->commit();
            return $stmt->rowCount();
        } catch (Exception $e) {
            $this->con->rollBack();
            throw new Exception("Error en update: " . $e->getMessage());
        }

        return false;
    }

    function delete($id) {
        $this->conexion();
        $this->con->beginTransaction();
    
        try {
            if (!is_null($id) && is_numeric($id)) {
                $sql = "SELECT * FROM producto WHERE id = :id";
                $stmt = $this->con->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if ($producto) {
                    $sql = "DELETE FROM producto WHERE id = :id";
                    $stmt = $this->con->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
    
                    if ($stmt->rowCount() > 0) {
                        if ($producto['foto'] && $producto['foto'] !== 'default.png') {
                            $this->deleteImage($producto['foto']);
                        }
    
                        $this->con->commit();
                        return true;
                    } else {
                        throw new Exception("No se pudo eliminar el producto de la base de datos.");
                    }
                } else {
                    throw new Exception("El producto no existe.");
                }
            } else {
                throw new Exception("ID de producto no válido.");
            }
        } catch (Exception $e) {
            $this->con->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    function readOne ($id){
        $result = [];
        $this->conexion();
        $this -> con->beginTransaction();

        try {
            $consulta = 'select * from producto where id=:id;';
            $sql = $this->con->prepare($consulta);
            $sql->bindParam(":id",$id,PDO::PARAM_INT);
            $sql -> execute();

            $result = $sql->fetch(PDO::FETCH_ASSOC);

            $this -> con -> commit();

            return $result;
        } catch (Exception $e) {
            $this -> con->rollback();
            echo "". $e -> getMessage() ."";
        }

        return false;
    }

    function readAll(){
        $result = [];
        $this -> conexion();
        $this -> con -> beginTransaction();

        try {
            $consulta ='select * from producto;';
            $sql = $this->con->prepare ($consulta); 
            $sql -> execute();
            $result = $sql -> fetchALL(PDO::FETCH_ASSOC);    
            $this -> con -> commit();
            return $result;
        } catch (Exception $e) {
            $this -> con->rollback();
            echo ''. $e -> getMessage() .'';
        }
        
        return false;
    }

    function uploadFoto() {
        $tipos = array("image/jpeg", "image/png", "image/gif", "image/webp");
        $data = $_FILES['foto'];

        $default = "default.png";
        if($data['error'] == 0) {
            if ($data['size'] <= 5242880) {
                if (in_array($data['type'], $tipos)) {
                    $n = rand(1, 1000000);
                    $nombre = explode('.', $data['name']);
                    $imagen = md5($n.$nombre[0]).".".$nombre[sizeof($nombre) - 1];

                    $origen = $data['tmp_name'];
                    $destino = "C:\\xampp\\htdocs\\transitionToPhp\\image\\shop\\".$imagen;

                    if (move_uploaded_file($origen, $destino)) {
                        return $imagen;
                    }

                    return $default;
                }
            }
        }
        return $default;
    }

    function getImageById($id) {
        $this->conexion();
        $this->con->beginTransaction();
        try {
            $sql = "SELECT foto FROM producto WHERE id = :id";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $foto = $stmt->fetchColumn();
            $this->con->commit();
            return $foto;
        } catch (Exception $e) {
            $this->con->rollBack();
            throw new Exception("Error en getImageById: " . $e->getMessage());
        }
    }
    function deleteImage($filename) {
        try {
            $ruta_imagen = "C:\\xampp\\htdocs\\transitionToPhp\\image\\shop\\" . $filename;
    
            if (file_exists($ruta_imagen)) {
                if (!unlink($ruta_imagen)) {
                    throw new Exception("No se pudo eliminar la imagen del sistema de archivos.");
                }
            }
        } catch (Exception $e) {
            throw new Exception("Error en deleteImage: " . $e->getMessage());
        }
    }
 }
?>