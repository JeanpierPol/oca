<?php
    class Ficha{
        protected $db ;


        public function __construct(){
            $dsn ="mysql:host=localhost;dbname=daw2024;charset=utf8";
            $usuario = "jdoe@example.com";
            $pass = "pass123";

            try{
                
                $this->db = new PDO($dsn, $usuario, $pass);
            }catch(PDOException $e){
                die("Error en la conexion de la bases de datos" . $e->getMessage());
            }
            
        }

        public function crearFicha($numero_ficha,$nombre,$color,$posicion){
            try{
                $sql = "INSERT INTO ficha (numero_ficha ,nombre,color,posicion) VALUES(:nombre, :color, :posicion)";
                $smt = $this->db->prepare($sql);
                $smt->execute(array(':nombre' => $nombre, ':color' =>$color, ':posicion' => $posicion));
                
            }catch(PDOException $e){
                die("Error en la creacion de fichas" . $e->getMessage());
            }
        }

        public function obtenerFichas($id){
            try{
                $sql = "S";

            }catch(PDOException $e){
                die("Error en la obtencion de fichas" . $e->getMessage());
            }
        }


    }

    $fichaN = new Ficha();

?>

