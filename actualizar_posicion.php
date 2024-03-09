<?php
session_start();

if (isset($_SESSION['jugadores']) && isset($_POST['indice']) && isset($_POST['sumaDados'])) {
    include_once('./clases/Jugador.php');

    $n_jugador = $_POST['indice'];
    $jugador = $_SESSION['jugadores'][$n_jugador];
    $dados = $_POST['sumaDados'];
    $proximo_turno = ($n_jugador + 1) % count($_SESSION['jugadores']);

    if ($_SESSION['turno'] >= count($_SESSION['jugadores'])) {
        $_SESSION['turno'] = 1; 
    } else {
        $_SESSION['turno'] += 1; 
    }
    

    $posicion_actual = $_SESSION['jugadores'][$n_jugador]['posicion'];
    
    if ($posicion_actual + $dados < 63) {
        $_SESSION['jugadores'][$n_jugador]['posicion'] += $dados;
    } elseif($posicion_actual + $dados > 63){
        $retroceso = $posicion_actual + $dados - 63;
        echo "$retroceso";
        $_SESSION['jugadores'][$n_jugador]['posicion'] -= $retroceso;
    } elseif($posicion_actual + $dados == 63){
        echo "Has ganado";
    }
    
    
} else {
    echo "Error: Datos insuficientes o sesión no iniciada.";
}
?>
