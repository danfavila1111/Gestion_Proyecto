-- Creación de la base de datos
CREATE DATABASE tbk;

-- Selección de la base de datos
USE tbk;

-- Creación de la tabla "Usuarios"
CREATE TABLE Usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  correo VARCHAR(100),
  contrasena VARCHAR(100),
  rol ENUM('administrador', 'cliente')
);

-- Creación de la tabla "Servicios"
CREATE TABLE Servicios (
  id_servicio INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100)
);

-- Inserción de servicios
INSERT INTO Servicios (nombre)
VALUES
  ('Barbería'),
  ('Sesión de Tatuajes');

-- Creación de la tabla "Horarios"
CREATE TABLE Horarios (
  id_horario INT AUTO_INCREMENT PRIMARY KEY,
  id_servicio INT,
  fecha DATE,
  hora TIME,
  disponibilidad BOOLEAN,
  FOREIGN KEY (id_servicio) REFERENCES Servicios(id_servicio)
);

-- Creación de la tabla "Citas"
CREATE TABLE Citas (
  id_cita INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT,
  id_horario INT,
  FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario),
  FOREIGN KEY (id_horario) REFERENCES Horarios(id_horario)
);


INSERT INTO Usuarios (nombre, correo, contrasena, rol)
VALUES ('Daniel Avila', 'agosoto2004@gmail.com', '123456789', 'administrador');
INSERT INTO Usuarios (nombre, correo, contrasena, rol)
VALUES ('Andres Lozano', 'tovinow@gmail.com', '123456789', 'administrador');
INSERT INTO Usuarios (nombre, correo, contrasena, rol)
VALUES ('Jean Lopez', 'jealpez@soy.sena.edu.co', '123456789', 'administrador');

INSERT INTO Horarios (id_servicio, fecha, hora, disponibilidad)
VALUES
  (1, '2023-06-06', '09:00:00', TRUE),
  (1, '2023-06-06', '11:00:00', TRUE),
  (2, '2023-06-06', '14:00:00', TRUE),
  (1, '2023-06-07', '10:00:00', TRUE),
  (2, '2023-06-07', '12:00:00', TRUE),
  (2, '2023-06-07', '15:00:00', TRUE);


select * from Usuarios;
select * from Servicios;
select * from Horarios;
select * from Citas;

-- drop database tbk ;

