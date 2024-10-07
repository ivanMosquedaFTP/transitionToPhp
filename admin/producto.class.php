<?php
 require_once ('../sistema.class.php');

 class administrador extends sistema {
    function create ($data){
        $result = [];
        $insertar = [];
        $this -> conexion();
        $sql="insert into administrador(nombre, contrasena) values(:nombre, :contrasena);";
        $insertar = $this->con->prepare($sql);
        $insertar -> bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
        $insertar -> bindParam(':contrasena', $data['contrasena'], PDO::PARAM_STR);
        $insertar -> execute();
        $result = $insertar -> rowCount();
        return $result;
    }

    function update ($id, $data){
        $this->conexion();
        $result = [];
        if (is_numeric($id)) {
            $sql = 'update administrador set nombre=:nombre, contrasena=:contrasena where id=:id;';
            $modificar=$this->con->prepare($sql);
            $modificar->bindParam(':nombre',$data['nombre'], PDO::PARAM_STR);
            $modificar->bindParam(':contrasena',$data['contrasena'], PDO::PARAM_STR);
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
            $sql = "delete from administrador where id=:id;";
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
        $consulta = 'select * from administrador where id=:id;';
        $sql = $this->con->prepare($consulta);
        $sql->bindParam(":id",$id,PDO::PARAM_INT);
        $sql -> execute();

        $result = $sql->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function readAll (){
        $this -> conexion();
        $result = [];
        $consulta ='select * from administrador;';
        $sql = $this->con->prepare ($consulta); 
        $sql -> execute();
        $result = $sql -> fetchALL(PDO::FETCH_ASSOC);    
        return $result;
    }
 }
?>