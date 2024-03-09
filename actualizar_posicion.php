<?php
session_start();

if (isset($_SESSION['jugadores']) && isset($_POST['indice']) && isset($_POST['sumaDados'])) {
    include_once('./clases/Jugador.php');

    $n_jugador = $_POST['indice'];
    $jugador = $_SESSION['jugadores'][$n_jugador];
    $dados = $_POST['sumaDados'];
    $proximo_turno = ($n_jugador + 1) % count($_SESSION['jugadores']);
    $fecha_y_hora_actuales = date("d-m-Y H:i:s");
    $sesion_actual = $_SESSION['turno'];

    if ($sesion_actual >= count($_SESSION['jugadores'])) {
        $_SESSION['turno'] = 1;
    } else {
        $_SESSION['turno'] += 1;
    }



    $posicion_actual = $_SESSION['jugadores'][$n_jugador]['posicion'];
    $registo_movimiento_jugador = "";
    $casillas_especiales = $_POST['casillas_especiales'];

    if ($posicion_actual + $dados < 63) {
        $_SESSION['jugadores'][$n_jugador]['posicion'] += $dados;
        $registo_movimiento_jugador = $jugador['nombre']  .  " esta en la posicion $posicion_actual y avanzara $dados casillas a las $fecha_y_hora_actuales";
    } elseif ($posicion_actual + $dados > 63) {
        $rebote = $posicion_actual + $dados - 63;
        $registo_movimiento_jugador = $jugador['nombre']  .  " esta en la posicion $posicion_actual y avanzara $dados casillas pero reboto a la casilla " .  $posicion_actual - $rebote   . " a las $fecha_y_hora_actuales";
        $_SESSION['jugadores'][$n_jugador]['posicion'] -= $rebote;
    } elseif (in_array($posicion_actual + $dados, $casillas_especiales)) {
        $_SESSION['jugadores'][$n_jugador]['posicion'] += $dados;
        $_SESSION['turno'] = $sesion_actual;
        $registo_movimiento_jugador = $jugador['nombre']  .  " esta en la posicion $posicion_actual y avanzara $dados casillas a las, volvera a lanzar porque cayo en una casilla especial $fecha_y_hora_actuales";
    } elseif ($posicion_actual + $dados == 63) {
        $registo_movimiento_jugador = $jugador['nombre'] . "ha ganado";
    }




    //Historial de la partida o log
    $nombreLog = "log_" . date("d_m_Y") . ".txt";
    $rutaLog = __DIR__ . "/log/";

    if (!file_exists($rutaLog)) {
        mkdir($rutaLog, 0644, true);
    }

    $log = fopen($rutaLog . $nombreLog, "a");
    fwrite($log, $registo_movimiento_jugador . PHP_EOL);
    fclose($log);
} else {
    echo "Error: Datos insuficientes o sesión no iniciada.";
}
