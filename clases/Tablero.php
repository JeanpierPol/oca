<?php
    include_once('./constantes_globales.php');
    class Tablero{
        public $cantidad_casilla = CASILLAS;
        public $casillas_especiales = CASILLAS_ESPECIALES;
        public $tiempo_de_juego;
        public $turno;
        public $n_jugadores;

        public function __construct($n_jugadores) {
            $this->n_jugadores = $n_jugadores;            
        }
        
        public function get_cantidad_casillas(){
            return $this->cantidad_casilla;
        }
        public function get_casillas_especiales(){
            return $this->casillas_especiales;
        }

        public function jugadorAlFinal($posicion) {
            return $posicion >= $this->cantidad_casilla;
        }
    }

?>