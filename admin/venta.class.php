<?php
 require_once ('../sistema.class.php');

 class venta extends sistema {
    function create ($data){
        $result = [];
        $insertar = [];
        $this -> conexion();
        $sql="insert into venta(usuario_id, producto_id, cantidad) values(:usuario_id, :producto_id, :cantidad);";
        $insertar = $this->con->prepare($sql);
        $insertar -> bindParam(':usuario_id', $data['usuario_id'], PDO::PARAM_INT);
        $insertar -> bindParam(':producto_id', $data['producto_id'], PDO::PARAM_INT);
        $insertar -> bindParam(':cantidad', $data['cantidad'], PDO::PARAM_INT);
        $insertar -> execute();
        $result = $insertar -> rowCount();
        return $result;
    }

    function update ($id, $data){
        $this->conexion();
        $result = [];
        if (is_numeric($id)) {
            $sql = 'update venta set usuario_id=:usuario_id, producto_id=:producto_id, cantidad=:cantidad where id=:id;';
            $modificar=$this->con->prepare($sql);
            $modificar->bindParam(':usuario_id',$data['usuario_id'], PDO::PARAM_STR);
            $modificar->bindParam(':producto_id',$data['producto_id'], PDO::PARAM_STR);
            $modificar->bindParam(':cantidad',$data['cantidad'], PDO::PARAM_STR);
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
            $sql = "delete from venta where id=:id;";
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
        $consulta = 'select * from venta where id=:id;';
        $sql = $this->con->prepare($consulta);
        $sql->bindParam(":id",$id,PDO::PARAM_INT);
        $sql -> execute();

        $result = $sql->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function readAll (){
        $this -> conexion();
        $result = [];
        $consulta ='select v.*, u.nombre_completo, p.nombre_producto from venta v inner join usuario u on v.usuario_id = u.id inner join produto p on v.producto_id = p.id;';
        $sql = $this->con->prepare ($consulta); 
        $sql -> execute();
        $result = $sql -> fetchALL(PDO::FETCH_ASSOC);    
        return $result;
    }
 }
?>
