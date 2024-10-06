<?php
 require_once ('../sistema.class.php');

 class producto extends sistema {
    function create ($data){
        $result = [];
        $insertar = [];
        $this -> conexion();
        $sql="insert into producto(nombre_producto, descripcion, precio, stock) values(:nombre_producto, :descripcion, :precio, :stock);";
        $insertar = $this->con->prepare($sql);
        $insertar -> bindParam(':nombre_producto', $data['nombre_producto'], PDO::PARAM_STR);
        $insertar -> bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
        $precio = strval($data['precio']);
        $insertar -> bindParam(':precio', $data['precio'], PDO::PARAM_STR);
        $insertar -> bindParam(':stock', $data['stock'], PDO::PARAM_INT);
        $insertar -> execute();
        $result = $insertar -> rowCount();
        return $result;
    }

    function update ($id, $data){
        $this->conexion();
        $result = [];
        if (is_numeric($id)) {
            $sql = 'update producto set nombre_producto=:nombre_producto=:nombre_producto, descripcion=:descripcion, precio=:precio, stock=:stock where id=:id;';
            $modificar=$this->con->prepare($sql);
            $modificar->bindParam(':nombre_producto',$data['nombre_producto'], PDO::PARAM_STR);
            $modificar->bindParam(':descripcion',$data['descripcion'], PDO::PARAM_STR);
            $precio = strval($data['precio']);
            $modificar->bindParam(':precio',$data['precio'], PDO::PARAM_STR);
            $modificar->bindParam(':stock',$data['stock'], PDO::PARAM_INT);
            $modificar->bindParam(':id',$id, PDO::PARAM_INT);
            $modificar->execute();
            $result= $modificar->rowCount();
        }
        return $result;
    }

    function delete ($id){
        $this -> conexion();
        $result = [];
        if (is_numeric($id)) {
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

    function readAll (){
        $this -> conexion();
        $result = [];
        $consulta ='select * from producto;';
        $sql = $this->con->prepare ($consulta); 
        $sql -> execute();
        $result = $sql -> fetchALL(PDO::FETCH_ASSOC);    
        return $result;
    }
 }
?>
