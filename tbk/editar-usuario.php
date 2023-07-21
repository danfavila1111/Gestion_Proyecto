<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Usuario</title>
  <!-- Estilos de Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <div class="container">
    <h1>Editar Usuario</h1>

    <?php
    // Verificar si se recibió el parámetro id
    if (isset($_GET['id'])) {
      $idUsuario = $_GET['id'];

      // Verificar si se envió el formulario de edición
      if (isset($_POST['editar'])) {
        // Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];

        // Conectar a la base de datos
        $servername = "localhost:3306";
        $username = "root";
        $password = "";
        $dbname = "tbk";

        $conexion = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conexion) {
          die("Error al conectar a la base de datos: " . mysqli_connect_error());
        }

        // Actualizar los datos del usuario en la base de datos
        $sqlActualizarUsuario = "UPDATE Usuarios SET nombre = '$nombre', correo = '$correo', contrasena = '$contrasena' WHERE id_usuario = $idUsuario";
        $resultadoActualizarUsuario = mysqli_query($conexion, $sqlActualizarUsuario);

        // Verificar el resultado de la actualización
        if ($resultadoActualizarUsuario) {
          // Usuario actualizado correctamente
          $mensaje = "Usuario actualizado correctamente.";
          echo "<div class='alert alert-success' role='alert'>" . $mensaje . "</div>";
        } else {
          // Error al actualizar el usuario
          $mensaje = "Error al actualizar el usuario. Por favor, intenta nuevamente.";
          echo "<div class='alert alert-danger' role='alert'>" . $mensaje . "</div>";
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($conexion);

        // Redireccionar a usuario.php
        echo "<script>window.location.href = 'usuario.php';</script>";
      } else {
        // Conectar a la base de datos
        $servername = "localhost:3306";
        $username = "root";
        $password = "";
        $dbname = "tbk";

        $conexion = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conexion) {
          die("Error al conectar a la base de datos: " . mysqli_connect_error());
        }

        // Obtener los datos del usuario de la base de datos
        $sqlObtenerUsuario = "SELECT * FROM Usuarios WHERE id_usuario = $idUsuario";
        $resultadoObtenerUsuario = mysqli_query($conexion, $sqlObtenerUsuario);

        // Verificar si se encontró el usuario
        if ($resultadoObtenerUsuario && mysqli_num_rows($resultadoObtenerUsuario) > 0) {
          $usuario = mysqli_fetch_assoc($resultadoObtenerUsuario);
    ?>

          <!-- Formulario de Edición -->
          <form action="editar-usuario.php?id=<?php echo $idUsuario; ?>" method="POST">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre:</label>
              <input type="text" class="form-control" name="nombre" value="<?php echo $usuario['nombre']; ?>">
            </div>
            <div class="mb-3">
              <label for="correo" class="form-label">Correo:</label>
              <input type="text" class="form-control" name="correo" value="<?php echo $usuario['correo']; ?>">
            </div>
            <div class="mb-3">
              <label for="contrasena" class="form-label">Contraseña:</label>
              <input type="password" class="form-control" name="contrasena" value="<?php echo $usuario['contrasena']; ?>">
            </div>
            <button type="submit" name="editar" class="btn btn-primary">Editar</button>
          </form>

    <?php
        } else {
          // No se encontró el usuario
          $mensaje = "El usuario no existe. Por favor, intenta nuevamente.";
          echo "<div class='alert alert-danger' role='alert'>" . $mensaje . "</div>";

          // Redireccionar a usuario.php
          echo "<script>window.location.href = 'usuario.php';</script>";
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($conexion);
      }
    } else {
      // No se recibió el parámetro id
      $mensaje = "No se ha proporcionado un ID de usuario válido.";
      echo "<div class='alert alert-danger' role='alert'>" . $mensaje . "</div>";

      // Redireccionar a usuario.php
      echo "<script>window.location.href = 'usuario.php';</script>";
    }
    ?>

  </div>

  <!-- Scripts de Bootstrap -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>
</body>

</html>
