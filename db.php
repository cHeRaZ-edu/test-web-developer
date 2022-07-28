<?php
    class db {
        static public function connect() {
            $host = "localhost";
            $db = "db_personal";
            $user = "root";
            $pass = "";
            try {
                $mysqli = new mysqli($host,$user,$pass,$db);
                if ($mysqli->connect_errno) {
                    $response = (object)array("status"=>500,"message"=>$mysqli->connect_error);
                    echo json_encode($response);
                    die("Error de conexión: " . $mysqli->connect_error);
                }

            } catch(Exception $e) {
                $response = (object)array("status"=>500,"message"=>"Error a conectarse a la base de datos, favor de crear la base de datos en el archivo database.sql o configurar el usuario y contraseña en el archivo db.php");
                echo json_encode($response);
                exit;
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
            try {
                $id = $mysqli->query($sql);
            } catch(Exception $e) {
                $response = (object)array("status"=>500,"message"=>"Error, la tabla personal no está creada.");
                echo json_encode($response);
                exit;
            }
           
           return db::BuscarPersonal($mysqli,$id);
        }
        static public function ObtenerPersonal($mysqli) {
            $sql = "SELECT * FROM personal;";
            $personal = [];
            try {
                $result = $mysqli->query($sql);
                while($row = $result->fetch_assoc()) {
                    array_push($personal, $row);
                }
            } catch(Exception $e) {
                $response = (object)array("status"=>500,"message"=>"Error, la tabla personal no está creada.");
                echo json_encode($response);
                exit;
            }
            
            return $personal;
        }
        static public function BuscarPersonal($mysqli,$id) {
            $sql = "SELECT * FROM personal WHERE id = " . $id .";";
            $personal = null;
            try {
                $result = $mysqli->query($sql);
                while($row = $result->fetch_assoc()) {
                    $personal = $row;
                }
            } catch(Exception $e) {
                $response = (object)array("status"=>500,"message"=>"Error, la tabla personal no está creada.");
                echo json_encode($response);
                exit;
            }
            
            return $personal;
        }
    }
?>