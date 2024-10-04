<?php
 require_once ('../sistema.class.php');

 class Invernadero extends sistema {
    function create ($data){
        $result = [];
        $insertar = [];
        $this -> conexion();
        $sql="insert into invernadero(area, fecha_creacion, invernadero, latitud, longitud) values(:area, :fecha_creacion, :invernadero, :latitud, :longitud);";
        $insertar = $this->con->prepare($sql);
        $insertar -> bindParam(':area', $data['area'], PDO::PARAM_INT);
        $insertar -> bindParam(':fecha_creacion', $data['fecha_creacion'], PDO::PARAM_STR);
        $insertar -> bindParam(':invernadero', $data['invernadero'], PDO::PARAM_STR);
        $insertar -> bindParam(':latitud', $data['latitud'], PDO::PARAM_STR);
        $insertar -> bindParam(':longitud', $data['longitud'], PDO::PARAM_STR);
        $insertar -> execute();
        $result = $insertar -> rowCount();
        return $result;
    }

    function update ($id, $data){
        $this->conexion();
        $result = [];
        $sql = 'update invernadero set invernadero=:invernadero, latitud=:latitud,longitud=:longitud,area=:area, fecha_creacion=:fecha_creacion where id_invernadero=:id_invernadero;';
        $modificar=$this->con->prepare($sql);
        $modificar->bindParam(':id_invernadero',$id, PDO::PARAM_INT);
        $modificar->bindParam(':invernadero',$data['invernadero'], PDO::PARAM_STR);
        $modificar->bindParam(':longitud',$data['longitud'], PDO::PARAM_STR);
        $modificar->bindParam(':latitud',$data['latitud'], PDO::PARAM_STR);
        $modificar->bindParam(':area',$data['area'], PDO::PARAM_INT);
        $modificar->bindParam(':fecha_creacion',$data['fecha_creacion'], PDO::PARAM_STR);
        $modificar->execute();
        $result= $modificar->rowCount();
        return $result;
    }

    function delete ($id){
        $this -> conexion();
        $result = [];
        $sql = "delete from invernadero where id_invernadero=:id_invernadero;";
        $eliminar = $this->con->prepare($sql);
        $eliminar -> bindParam(':id_invernadero', $id, PDO::PARAM_INT);
        $eliminar -> execute();
        $result = $eliminar -> rowCount();
        return $result;
    }

    function readOne ($id){
        $this->conexion();
        $result = [];
        $consulta = 'SELECT * FROM invernadero where id_invernadero=:id_invernadero;';
        $sql = $this->con->prepare($consulta);
        $sql->bindParam(":id_invernadero",$id,PDO::PARAM_INT);
        $sql -> execute();

        $result = $sql->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function readAll (){
        $this -> conexion();
        $result = [];
        $consulta ='select * from invernadero';
        $sql = $this->con->prepare ($consulta); 
        $sql -> execute();
        $result = $sql -> fetchALL(PDO::FETCH_ASSOC);    
        return $result;
    }
 }
?>