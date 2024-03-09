<?php
session_start();

if (isset($_SESSION['jugadores']) && isset($_POST['indice']) && isset($_POST['sumaDados'])) {
    include_once('./clases/Jugador.php');

    $n_jugador = $_POST['indice'];
    $jugador = $_SESSION['jugadores'][$n_jugador];
    $dados = $_POST['sumaDados'];
    $proximo_turno = ($n_jugador + 1) % count($_SESSION['jugadores']);
    $fecha_y_hora_actuales = date("d-m-Y H:i:s");

    if ($_SESSION['turno'] >= count($_SESSION['jugadores'])) {
        $_SESSION['turno'] = 1; 
    } else {
        $_SESSION['turno'] += 1; 
    }
    

    $posicion_actual = $_SESSION['jugadores'][$n_jugador]['posicion'];
    
    if ($posicion_actual + $dados < 63) {
        $_SESSION['jugadores'][$n_jugador]['posicion'] += $dados;
    } elseif($posicion_actual + $dados > 63){
        $rebote = $posicion_actual + $dados - 63;
        echo "$rebote";
        $_SESSION['jugadores'][$n_jugador]['posicion'] -= $rebote;
    } elseif($posicion_actual + $dados == 63){
        echo "Has ganado";
    }
    

    //escritura de logs
    $nombreLog ="log_". date("d_m_Y").".txt"; 
    $registo_movimiento_jugador = $jugador['nombre']  .  " esta en la posicion $posicion_actual y avanzara $dados casillas a las $fecha_y_hora_actuales";   
    
    $log = fopen(__DIR__."/log/$nombreLog", "a");
    fwrite($log, $registo_movimiento_jugador . PHP_EOL);
    fclose($log);
    

    
    
    
} else {
    echo "Error: Datos insuficientes o sesión no iniciada.";
}
?>
