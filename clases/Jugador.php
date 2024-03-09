<?php
    class Jugador{
        public $nombre;
        public $color;
        public $posicion;

        public function __construct($nombre, $color){
            $this->nombre = $nombre;
            $this->color = $color;
            $this->posicion = 0;
        }

        public function set_posicion($dado){
            $this->posicion = $this->posicion + $dado;
        }
        public function get_posicion(){
            return $this->posicion;
        }
    }

?>

