<?php
 require_once ('../sistema.class.php');

 class usuario extends sistema {
    function create ($data){
        $result = [];
        $insertar = [];
        $this -> conexion();
        $sql="insert into usuario(nombre_completo, telefono, contrasena, email, total_compras) values(:nombre_completo, :telefono, :contrasena, :email, :total_compras);";
        $insertar = $this->con->prepare($sql);
        $insertar -> bindParam(':nombre_completo', $data['nombre_completo'], PDO::PARAM_STR);
        $insertar -> bindParam(':telefono', $data['telefono'], PDO::PARAM_STR);
        $insertar -> bindParam(':contrasena', $data['contrasena'], PDO::PARAM_STR);
        $insertar -> bindParam(':email', $data['email'], PDO::PARAM_STR);
        $insertar -> bindParam(':total_compras', $data['total_compras'], PDO::PARAM_INT);
        $insertar -> execute();
        $result = $insertar -> rowCount();
        return $result;
    }

    function update ($id, $data){
        $this->conexion();
        $result = [];
        if (is_numeric($id)) {
            $sql = 'update usuario set nombre_completo=:nombre_completo, telefono=:telefono, contrasena=:contrasena, email=:email, total_compras=:total_compras where id=:id;';
            $modificar=$this->con->prepare($sql);
            $modificar->bindParam(':nombre_completo',$data['nombre_completo'], PDO::PARAM_STR);
            $modificar->bindParam(':telefono',$data['telefono'], PDO::PARAM_STR);
            $modificar->bindParam(':contrasena',$data['contrasena'], PDO::PARAM_STR);
            $modificar->bindParam(':email',$data['email'], PDO::PARAM_STR);
            $modificar->bindParam(':total_compras',$data['total_compras'], PDO::PARAM_INT);
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
            $sql = "delete from usuario where id=:id;";
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
        $consulta = 'select * from usuario where id=:id;';
        $sql = $this->con->prepare($consulta);
        $sql->bindParam(":id",$id,PDO::PARAM_INT);
        $sql -> execute();

        $result = $sql->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function readAll (){
        $this -> conexion();
        $result = [];
        $consulta ='select * from usuario;';
        $sql = $this->con->prepare ($consulta); 
        $sql -> execute();
        $result = $sql -> fetchALL(PDO::FETCH_ASSOC);    
        return $result;
    }
 }
?>
