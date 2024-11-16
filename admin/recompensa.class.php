<?php
 require_once ('../sistema.class.php');

 class recompensa extends sistema {
    function create ($data){
        $result = [];
        $insertar = [];
        $this -> conexion();
        $sql="insert into recompensa(usuario_id, descripcion) values(:usuario_id, :descripcion);";
        $insertar = $this->con->prepare($sql);
        $insertar -> bindParam(':usuario_id', $data['usuario_id'], PDO::PARAM_STR);
        $insertar -> bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
        $insertar -> execute();
        $result = $insertar -> rowCount();
        return $result;
    }

    function update ($id, $data){
        $this->conexion();
        $result = [];
        if (is_numeric($id)) {
            $sql = 'update recompensa set usuario_id=:usuario_id, descripcion=:descripcion, fecha_otorgada=:fecha_otorgada where id=:id;';
            $modificar=$this->con->prepare($sql);
            $modificar->bindParam(':usuario_id',$data['usuario_id'], PDO::PARAM_STR);
            $modificar->bindParam(':descripcion',$data['descripcion'], PDO::PARAM_STR);
            $modificar->bindParam(':fecha_otorgada',$data['fecha_otorgada'], PDO::PARAM_STR);
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
            $sql = "delete from recompensa where id=:id;";
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
        $consulta = 'select * from recompensa where id=:id;';
        $sql = $this->con->prepare($consulta);
        $sql->bindParam(":id",$id,PDO::PARAM_INT);
        $sql -> execute();

        $result = $sql->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function readAll (){
        $this -> conexion();
        $result = [];
        $consulta ='select r.*, u.nombre_completo from recompensa r inner join usuario u on r.usuario_id = u.id;';
        $sql = $this->con->prepare ($consulta); 
        $sql -> execute();
        $result = $sql -> fetchALL(PDO::FETCH_ASSOC);
        return $result;
    }
 }
?>
