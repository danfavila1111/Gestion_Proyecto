<?php
// Verificar si se recibió el parámetro id
if (isset($_GET['id'])) {
  $idUsuario = $_GET['id'];

  // Conectar a la base de datos
  $servername = "localhost:3306";
  $username = "root";
  $password = "";
  $dbname = "tbk";

  $conexion = mysqli_connect($servername, $username, $password, $dbname);

  if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
  }

  // Eliminar el usuario de la base de datos
  $sqlEliminarUsuario = "DELETE FROM Usuarios WHERE id_usuario = $idUsuario";
  $resultadoEliminarUsuario = mysqli_query($conexion, $sqlEliminarUsuario);

  // Verificar el resultado de la eliminación
  if ($resultadoEliminarUsuario) {
    // Usuario eliminado correctamente
    $mensaje = "Usuario eliminado correctamente.";
    echo "<script>alert('" . $mensaje . "');</script>";
  } else {
    // Error al eliminar el usuario
    $mensaje = "Error al eliminar el usuario. Por favor, intenta nuevamente.";
    echo "<script>alert('" . $mensaje . "');</script>";
  }

  // Cerrar la conexión a la base de datos
  mysqli_close($conexion);
}

// Redireccionar a usuario.php
echo "<script>window.location.href = 'usuario.php';</script>";
?>