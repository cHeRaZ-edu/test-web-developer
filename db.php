<?php
    class db {
        static public function connect() {
            $host = "localhost";
            $db = "db_personal";
            $user = "root";
            $pass = "";
            $mysqli = new mysqli($host,$user,$pass,$db);
            if ($mysqli->connect_errno) {
                die("Error de conexión: " . $mysqli->connect_error);
            }
            return $mysqli;
        }
        static public function CrearPersonal($mysqli,$personal) {
            $sql = "INSERT INTO personal(nombre_completo,edad,genero,fecha_nacimiento,email) VALUES (" .
            "'" . $personal->fullName . "'," .
            $personal->edad . ","  .
            "'" . $personal->genero . "'," .
            "'" . $personal->fechaNacimiento . "'," .
            "'" . $personal->email . "')";
           $id = $mysqli->query($sql);
           return db::BuscarPersonal($mysqli,$id);

        }
        static public function ObtenerPersonal($mysqli) {
            $sql = "SELECT * FROM personal;";
            $result = $mysqli->query($sql);
            $personal = [];
            while($row = $result->fetch_assoc()) {
                array_push($personal, $row);
            }
            return $personal;
        }
        static public function BuscarPersonal($mysqli,$id) {
            $sql = "SELECT * FROM personal WHERE id = " . $id .";";
            $result = $mysqli->query($sql);
            $personal = null;
            while($row = $result->fetch_assoc()) {
                $personal = $row;
            }
            return $personal;
        }
    }
?>