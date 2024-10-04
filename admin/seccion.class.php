<?php
 require_once ('../sistema.class.php');

 class Seccion extends sistema {
    function create ($data){
        $result = [];
        $insertar = [];
        $this -> conexion();
        $sql="insert into seccion(area, seccion, id_invernadero) values(:area, :seccion, :id_invernadero);";
        $insertar = $this->con->prepare($sql);
        $insertar -> bindParam(':area', $data['area'], PDO::PARAM_INT);
        $insertar -> bindParam(':seccion', $data['seccion'], PDO::PARAM_STR);
        $insertar -> bindParam(':id_invernadero', $data['id_invernadero'], PDO::PARAM_INT);
        $insertar -> execute();
        $result = $insertar -> rowCount();
        return $result;
    }

    function update ($id, $data){
        $this->conexion();
        $result = [];
        $sql = 'update seccion set seccion=:seccion, area=:area, id_invernadero=:id_invernadero where id_seccion=:id_seccion;';
        $modificar=$this->con->prepare($sql);
        $modificar->bindParam(':seccion',$data['seccion'], PDO::PARAM_STR);
        $modificar->bindParam(':area',$data['area'], PDO::PARAM_INT);
        $modificar->bindParam(':id_invernadero',$data['id_invernadero'], PDO::PARAM_INT);
        $modificar->bindParam(':id_seccion',$id, PDO::PARAM_INT);
        $modificar->execute();
        $result= $modificar->rowCount();
        return $result;
    }

    function delete ($id){
        $this -> conexion();
        $result = [];
        if (is_numeric($id)) {
            $sql = "delete from seccion where id_seccion=:id_seccion;";
            $eliminar = $this->con->prepare($sql);
            $eliminar -> bindParam(':id_seccion', $id, PDO::PARAM_INT);
            $eliminar -> execute();
            $result = $eliminar -> rowCount();
        }
        return $result;
    }

    function readOne ($id){
        $this->conexion();
        $result = [];
        $consulta = 'SELECT * FROM seccion where id_seccion=:id_seccion;';
        $sql = $this->con->prepare($consulta);
        $sql->bindParam(":id_seccion",$id,PDO::PARAM_INT);
        $sql -> execute();

        $result = $sql->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function readAll (){
        $this -> conexion();
        $result = [];
        $consulta ='select s.*, i.invernadero from seccion s join invernadero i on s.id_invernadero=i.id_invernadero;';
        $sql = $this->con->prepare ($consulta); 
        $sql -> execute();
        $result = $sql -> fetchALL(PDO::FETCH_ASSOC);    
        return $result;
    }
 }
?>