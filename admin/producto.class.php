<?php
 require_once ('../sistema.class.php');

 class producto extends sistema {
    function create ($data){
        $result = [];
        $insertar = [];
        $this -> conexion();
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
        $result = $insertar -> rowCount();
        return $result;
    }

    function update ($id, $data){
        $this->conexion();
        $result = [];
        if (is_numeric($id)) {
            $sql = 'update producto set nombre_producto=:nombre_producto=:nombre_producto, descripcion=:descripcion, precio=:precio, stock=:stock, foto=:foto where id=:id;';
            $modificar=$this->con->prepare($sql);
            $modificar->bindParam(':nombre_producto',$data['nombre_producto'], PDO::PARAM_STR);
            $modificar->bindParam(':descripcion',$data['descripcion'], PDO::PARAM_STR);
            $precio = strval($data['precio']);
            $modificar->bindParam(':precio',$data['precio'], PDO::PARAM_STR);
            $modificar->bindParam(':stock',$data['stock'], PDO::PARAM_INT);
            $modificar -> bindParam(':foto', $data['foto'], PDO::PARAM_STR);
            $modificar->bindParam(':id',$id, PDO::PARAM_INT);
            $modificar->execute();
            $result= $modificar->rowCount();
        }
        return $result;
    }

    function delete ($id){
        $this -> conexion();
        $result = [];
        if (!is_null($id) && is_numeric($id)) {
            $sql = "delete from producto where id=:id;";
            $eliminar = $this->con->prepare($sql);
            $eliminar -> bindParam(':id', $id, PDO::PARAM_INT);
            $eliminar -> execute();
            $result = $eliminar -> rowCount();
        }
        return $result;
    }

    function readOne ($id){
        $this->conexion();
        $result = [];
        $consulta = 'select * from producto where id=:id;';
        $sql = $this->con->prepare($consulta);
        $sql->bindParam(":id",$id,PDO::PARAM_INT);
        $sql -> execute();

        $result = $sql->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function readAll(){
        $this -> conexion();
        $result = [];
        $consulta ='select * from producto;';
        $sql = $this->con->prepare ($consulta); 
        $sql -> execute();
        $result = $sql -> fetchALL(PDO::FETCH_ASSOC);    
        return $result;
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

    function deleteImage($id) {
        $this->conexion();

        $sql = "SELECT foto FROM producto WHERE id = :id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $foto = $stmt->fetchColumn();
    
        if ($foto && $foto !== 'default.png') {
            $ruta_imagen = "C:\\xampp\\htdocs\\transitionToPhp\\image\\shop\\" . $foto;
            if (file_exists($ruta_imagen)) {
                print_r($ruta_imagen);
                die();
                // unlink($ruta_imagen);
            }
        }
    }
 }
?>