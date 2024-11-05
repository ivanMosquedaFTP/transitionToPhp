<?php
 require_once ('../sistema.class.php');

 class usuario extends sistema {
  function create($data) {
    $result = [];
    $insertar = [];
    $this->conexion();
    $rol = $data['rol'];
    $data = $data['data'];
    $this->con->beginTransaction();

    try {
      $sql = "INSERT INTO usuario(nombre_completo, telefono, contrasena, email) VALUES(:nombre_completo, :telefono, md5(:contrasena), :email)";
      
      $insertar = $this->con->prepare($sql);
      $insertar->bindParam(':nombre_completo', $data['nombre_completo'], PDO::PARAM_STR);
      $insertar->bindParam(':telefono', $data['telefono'], PDO::PARAM_STR);
      $insertar->bindParam(':contrasena', $data['contrasena'], PDO::PARAM_STR);
      $insertar->bindParam(':email', $data['email'], PDO::PARAM_STR);
      
      // $currentDate = date('Y-m-d H:i:s');
      // $insertar->bindParam(':fecha_registro', $currentDate, PDO::PARAM_STR);
      // $insertar->bindParam(':total_compras', $data['total_compras'], PDO::PARAM_INT);

      $insertar->execute();

      $sql = "SELECT id FROM usuario WHERE email = :email";
      $consulta = $this->con->prepare($sql);
      $consulta->bindParam(':email', $data['email'], PDO::PARAM_STR);
      $consulta->execute();

      $datos = $consulta->fetch(PDO::FETCH_ASSOC);
      $id = isset($datos['id']) ? $datos['id'] : null;

      if (!is_null($id)) {
          foreach ($rol as $r => $k) {
              $sql = "INSERT INTO usuario_rol(id_usuario, id_rol) VALUES(:id_usuario, :id_rol)";
              $insertar_rol = $this->con->prepare($sql);
              $insertar_rol->bindParam(':id_usuario', $id, PDO::PARAM_INT);
              $insertar_rol->bindParam(':id_rol', $r, PDO::PARAM_INT);
              $insertar_rol->execute();
          }

          $this->con->commit();
          $result = $insertar->rowCount();
      }
     
      return $result;
    } catch(Exception $e) {
      $this->con->rollback();
      echo "Error: " . $e->getMessage();
    }

    return false;
  }

  // TODO: fix
  function update ($id, $data){
    $this->conexion();
    $rol = $data['rol'];
    $data = $data['data'];
    $this -> con -> beginTransaction();
    try {
      $sql = 'update usuario set correo = :correo, contrasena = md5(:contrasena) where id_usuario = :id_usuario;';
      $modificar=$this->con->prepare($sql);
      $modificar->bindParam(':correo',$data['correo'], PDO::PARAM_STR);
      $modificar->bindParam(':contrasena',$data['contrasena'], PDO::PARAM_STR);
      $modificar->bindParam(':id_usuario',$id, PDO::PARAM_INT);
      $modificar->execute();

      $sql = "delete from usuario_rol where id_usuario = :id_usuario;";
      $borrar_rol = $this -> con -> prepare($sql);
      $borrar_rol -> bindParam(':id_usuario', $id, PDO::PARAM_INT);
      $borrar_rol -> execute();

      if (!is_null($id)) {
        foreach($rol as $r => $k) {
          $sql = "insert into usuario_rol(id_usuario, id_rol) values(:id_usuario, :id_rol);";
          $insertar_rol = $this->con->prepare($sql);
          $insertar_rol -> bindParam(':id_usuario', $id, PDO::PARAM_INT);
          $insertar_rol -> bindParam(':id_rol', $r, PDO::PARAM_INT);
          $insertar_rol -> execute();
        }

        $this -> con ->commit();
        return $insertar_rol -> rowCount();
      }
    } catch (Exception $e) {
      $this -> con -> rollback();
    }

    return false;
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
        $consulta = 'SELECT * FROM usuario where id=:id;';
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

    function readAllRoles($id){
      $this -> conexion();
      $result = [];
      $sql ='select distinct r.id_rol from usuario u inner join usuario_rol ur on u.id=ur.id_usuario inner join rol r on ur.id_rol = r.id_rol where u.id = :id_usuario;';
      $consulta = $this->con->prepare ($sql); 
      $consulta->bindParam(":id_usuario",$id,PDO::PARAM_INT);
      $consulta -> execute();
      // $result = $consulta -> fetchALL(PDO::FETCH_ASSOC);

      $roles = [];
      $roles = $consulta -> fetchALL(PDO::FETCH_ASSOC);
      $data = [];
      foreach ($roles as $rol) {
        array_push($data, $rol['id_rol']);
      }

      return $data;
  }
 }
?>