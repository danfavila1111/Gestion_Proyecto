<?php
session_start();

// Verificar si el usuario ha iniciado sesión como administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'administrador') {
  header("Location: login.php");
  exit();
}

// Conectar a la base de datos
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "tbk";

$conexion = mysqli_connect($servername, $username, $password, $dbname);

if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$rol = $_POST['rol'];

// Insertar el usuario en la tabla Usuarios
$sqlInsertarUsuario = "INSERT INTO Usuarios (nombre, correo, contrasena, rol) VALUES ('$nombre', '$correo', '$contrasena', '$rol')";
$resultadoInsertarUsuario = mysqli_query($conexion, $sqlInsertarUsuario);

if ($resultadoInsertarUsuario) {
    // Usuario agregado con éxito
    $mensaje = "¡Usuario agregado con éxito!";
    echo "<script>alert('" . $mensaje . "');</script>";
    echo "<script>window.location.href = 'usuario.php?resultado=exito';</script>";
  } else {
    // Error al insertar el usuario
    $mensaje = "Error al agregar el usuario. Por favor, intenta nuevamente.";
    echo "<script>alert('" . $mensaje . "');</script>";
    echo "<script>window.location.href = 'usuario.php?resultado=error';</script>";
  }

// Redireccionar a usuario.php
echo "<script>window.location.href = 'usuario.php';</script>";

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>