<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'administrador') {
  header("Location: login.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_POST['nombre'];
  $correo = $_POST['correo'];
  $contrasena = $_POST['contrasena'];
  $rol = $_POST['rol'];

  $servername = "localhost:3306";
  $username = "root";
  $password = "";
  $dbname = "tbk";

  $conexion = mysqli_connect($servername, $username, $password, $dbname);

  if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
  }

  $query = "INSERT INTO Usuarios (nombre, correo, contrasena, rol) VALUES ('$nombre', '$correo', '$contrasena', '$rol')";
  $resultado = mysqli_query($conexion, $query);

  if ($resultado) {
    echo '<script>alert("Usuario agregado correctamente"); window.location.href = "admin.php";</script>';
    exit();
  } else {
    $_SESSION['error_message'] = "Error al agregar el usuario: " . mysqli_error($conexion);
    header("Location: admin.php");
    exit();
  }

  mysqli_close($conexion);

  header("Location: admin.php");
  exit();
}

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "tbk";

$conexion = mysqli_connect($servername, $username, $password, $dbname);

if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

$query = "SELECT * FROM Usuarios";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
  $usuarios = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
} else {
  die("Error al consultar los usuarios: " . mysqli_error($conexion));
}

mysqli_close($conexion);
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de administrador</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand navbar-brand-full" href="#">Página de administrador</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Cerrar sesión</a>
            <a class="nav-link" href="admin.php">Gestion de citas</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="left-container">
          <?php if (isset($_SESSION['success_message'])) : ?>
            <div class="alert alert-success" role="alert">
              <?php echo $_SESSION['success_message']; ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
          <?php endif; ?>

          <?php if (isset($_SESSION['error_message'])) : ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $_SESSION['error_message']; ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
          <?php endif; ?>

          <h3>Agregar nuevo usuario</h3>
          <form action="agregar-usuario.php" method="POST" class="add-form">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
              <label for="correo" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
              <label for="contrasena" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <div class="mb-3">
              <label for="rol" class="form-label">Rol</label>
              <select class="form-control" id="rol" name="rol" required>
                <option value="administrador">Administrador</option>
                <option value="cliente">Cliente</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        <div class="right-container">
          <br>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Correo electrónico</th>
                  <th>Rol</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($usuarios)) : ?>
                  <?php foreach ($usuarios as $usuario) : ?>
                    <tr>
                      <td><?php echo $usuario['nombre']; ?></td>
                      <td><?php echo $usuario['correo']; ?></td>
                      <td><?php echo $usuario['rol']; ?></td>
                      <td>
                        
                        <!-- Enlace Editar -->
                    <a href="editar-usuario.php?id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-primary btn-action"><i class="bi bi-pencil"></i></a>
                        <!-- Enlace Eliminar -->
                    <a href="eliminar-usuario.php?id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-danger btn-action"><i class="bi bi-trash"></i></a>

                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else : ?>
                  <tr>
                    <td colspan='4'>No hay usuarios disponibles.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YQ6wZkToHNIEF5U7HObdV2hplc/tvRIu2fXxv6lYhiJdNmNf2Am3iDdC00F6EJjD" crossorigin="anonymous"></script>
</body>

</html>
