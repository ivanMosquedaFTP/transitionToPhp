<?php
 require_once ('../sistema.class.php');

 class usuario extends sistema {
// acciones = crear y nuevo = agregar un nuevo usuario
// acciones = definir = definir nuevos permisos
// acciones = asignar = asignar permisos a roles
// acciones = enrolar = enrolar usuario a cierto role

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

  function createDesdeSnippet($data) {
    $result = [];
    $insertar = [];
    $this->conexion();
    $rol = 1;
    $data = $data['data'];
    $this->con->beginTransaction();

    try {
      $sql = "INSERT INTO usuario(nombre_completo, telefono, contrasena, email) VALUES(:nombre_completo, :telefono, md5(:contrasena), :email)";
      
      $insertar = $this->con->prepare($sql);
      $insertar->bindParam(':nombre_completo', $data['nombre_completo'], PDO::PARAM_STR);
      $insertar->bindParam(':telefono', $data['telefono'], PDO::PARAM_STR);
      $insertar->bindParam(':contrasena', $data['contrasena'], PDO::PARAM_STR);
      $insertar->bindParam(':email', $data['email'], PDO::PARAM_STR);
      
      $insertar->execute();

      $sql = "SELECT id FROM usuario WHERE email = :email";
      $consulta = $this->con->prepare($sql);
      $consulta->bindParam(':email', $data['email'], PDO::PARAM_STR);
      $consulta->execute();

      $datos = $consulta->fetch(PDO::FETCH_ASSOC);
      $id = isset($datos['id']) ? $datos['id'] : null;

      if (!is_null($id)) {
        $sql = "INSERT INTO usuario_rol(id_usuario, id_rol) VALUES(:id_usuario, :id_rol)";
        $insertar_rol = $this->con->prepare($sql);
        $insertar_rol->bindParam(':id_usuario', $id, PDO::PARAM_INT);
        $insertar_rol->bindParam(':id_rol', $rol, PDO::PARAM_INT);
        $insertar_rol->execute();

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

  function createDesdeLogin($data) {
    $result = [];
    $insertar = [];
    $this->conexion();
    $rol = 1;
    $data = $data['data'];
    $this->con->beginTransaction();

    try {
      $sql = "INSERT INTO usuario(nombre_completo, telefono, contrasena, email) VALUES(:nombre_completo, :telefono, md5(:contrasena), :email)";
      
      $insertar = $this->con->prepare($sql);
      $insertar->bindParam(':nombre_completo', $data['nombre_completo'], PDO::PARAM_STR);
      $insertar->bindParam(':telefono', $data['telefono'], PDO::PARAM_STR);
      $insertar->bindParam(':contrasena', $data['contrasena'], PDO::PARAM_STR);
      $insertar->bindParam(':email', $data['email'], PDO::PARAM_STR);
      
      $insertar->execute();

      $sql = "SELECT id FROM usuario WHERE email = :email";
      $consulta = $this->con->prepare($sql);
      $consulta->bindParam(':email', $data['email'], PDO::PARAM_STR);
      $consulta->execute();

      $datos = $consulta->fetch(PDO::FETCH_ASSOC);
      $id = isset($datos['id']) ? $datos['id'] : null;

      if (!is_null($id)) {
        $sql = "INSERT INTO usuario_rol(id_usuario, id_rol) VALUES(:id_usuario, :id_rol)";
        $insertar_rol = $this->con->prepare($sql);
        $insertar_rol->bindParam(':id_usuario', $id, PDO::PARAM_INT);
        $insertar_rol->bindParam(':id_rol', $rol, PDO::PARAM_INT);
        $insertar_rol->execute();

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

  function define($data) {
    if (!is_null($data)) {
      $insertar = [];

      $this -> con -> beginTransaction();

      try {
        $sql = "insert into permiso(permiso) values(':permiso');";
        $insertar = $this->con->prepare($sql);
        $insertar ->bindParam(":permiso", $data['permiso'], PDO::PARAM_STR);
        $insertar -> execute();

        $this -> con->commit();
        return $insertar -> rowCount();
      } catch (Exception $e) {
        $this -> con -> rollBack();
        echo 'error: '. $e->getMessage();
      }

      return false;
    }
  }

  function asign($data) {
    if (!is_null($data)) {
      $insertar = [];

      $this -> con -> beginTransaction();

      try {
        $sql = "insert into rol_permiso(id_rol, id_permiso) values(':id_rol, :id_permiso');";
        $insertar = $this->con->prepare($sql);
        $insertar ->bindParam(":id_rol", $data['id_rol'], PDO::PARAM_INT);
        $insertar ->bindParam(":id_permiso", $data['id_permiso'], PDO::PARAM_INT);
        $insertar -> execute();

        $this -> con->commit();
        return $insertar -> rowCount();
      } catch (Exception $e) {
        $this -> con -> rollBack();
        echo 'error: '. $e->getMessage();
      }

      return false;
    }
  }

  function enrole($data) {
    if (!is_null($data)) {
      $insertar = [];

      $this -> con -> beginTransaction();

      try {
        $sql = "insert into usuario_rol(id_usuario, id_rol) values(':id_usuario, :id_rol');";
        $insertar = $this->con->prepare($sql);
        $insertar ->bindParam(":id_usuario", $data['id_usuario'], PDO::PARAM_INT);
        $insertar ->bindParam(":id_rol", $data['id_rol'], PDO::PARAM_INT);
        $insertar -> execute();

        $this -> con->commit();
        return $insertar -> rowCount();
      } catch (Exception $e) {
        $this -> con -> rollBack();
        echo 'error: '. $e->getMessage();
      }

      return false;
    }
  }

  function update ($id, $data){
    if (!is_null($id) && !is_null($data) && is_numeric($id)) {
      $this->conexion();
      $rol = $data['rol'];
      $data = $data['data'];
      $this -> con -> beginTransaction();
      try {
        $sql = 'update usuario set nombre_completo = :nombre_completo, telefono = :telefono, contrasena = md5(:contrasena), email = :email, total_compras = :total_compras where id = :id;';
        $modificar=$this->con->prepare($sql);
        $modificar->bindParam(':nombre_completo',$data['nombre_completo'], PDO::PARAM_STR);
        $modificar->bindParam(':telefono',$data['telefono'], PDO::PARAM_STR);
        $modificar->bindParam(':contrasena',$data['contrasena'], PDO::PARAM_STR);
        $modificar->bindParam(':email',$data['email'], PDO::PARAM_STR);
        $modificar->bindParam(':total_compras',$data['total_compras'], PDO::PARAM_INT);
        $modificar->bindParam(':id',$id, PDO::PARAM_INT);
        $modificar->execute();

        $sql = "delete from usuario_rol where id_usuario = :id;";
        $borrar_rol = $this -> con -> prepare($sql);
        $borrar_rol -> bindParam(':id', $id, PDO::PARAM_INT);
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
        echo $e -> getMessage();
      }
    }

    return false;
  }

  function delete ($id){
    $this -> conexion();
    $this -> con -> beginTransaction();
    $result = [];
    if (!is_null($id) && is_numeric($id)) {
      try {
        $sql = 'delete from usuario_rol where id_usuario = :id_usuario;';
        $deleteRoles = $this -> con -> prepare($sql);
        $deleteRoles -> bindParam(':id_usuario', $id, PDO::PARAM_INT);
        $deleteRoles -> execute();

        $sql = "delete from usuario where id=:id;";
        $eliminar = $this->con->prepare($sql);
        $eliminar -> bindParam(':id', $id, PDO::PARAM_INT);
        $eliminar -> execute();

        $this -> con -> commit();
        return $eliminar -> rowCount();
      } catch (Exception $e) {
        $this -> con -> rollBack();
        echo $e -> getMessage();
      }
    }

    return false;
}

    function readOne ($id){
        $result = [];
        $this->conexion();

        $this -> con -> beginTransaction();

        try {
          $consulta = 'SELECT * FROM usuario where id=:id;';
          $sql = $this->con->prepare($consulta);
          $sql->bindParam(":id",$id,PDO::PARAM_INT);
          $sql -> execute();

          $result = $sql->fetch(PDO::FETCH_ASSOC);
          return $result;
        } catch (Exception $e) {
          $this -> con ->rollBack();
          echo $e -> getMessage();
        }

        return false;
    }

    function readAll (){
        $result = [];
        $this -> conexion();
        $this -> con->beginTransaction();

        try {
          $consulta ='select * from usuario;';
          $sql = $this->con->prepare ($consulta); 
          $sql -> execute();
          $result = $sql -> fetchALL(PDO::FETCH_ASSOC);    
          return $result;
        } catch (Exception $e) {
          $this -> con ->rollBack();
          echo $e -> getMessage();
        }

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