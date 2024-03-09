<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <?php
        include_once('constantes_globales.php');
        $n_jugadores = $_GET['n_jugadores'];
        if (isset($n_jugadores) && is_numeric($n_jugadores) && $n_jugadores > 1) {
            
            $jugadores = [];
            for ($i = 1; $i <= $n_jugadores; $i++) {
        ?>
                <label for="nombre_jugador">Nombre jugador <?= $i ?></label>
                <input type="text" name="jugadores[jugador<?= $i ?>][nombre]" id="nombre_jugador" value="">
                <input type="color" name="jugadores[jugador<?= $i ?>][color]" list="colores">
                <datalist id="colores">
                    <?php
                        foreach(COLORES_PERMITIDOS as $color){
                            ?>
                                <option><?= $color ?></option>
                            <?php
                        }
                    ?>
                    
                </datalist>
                
                <br>
            <?php
            }
            ?>
            <input type="submit" value="Enviar">
        <?php

        } else {
            echo "Error: numero invalido de jugadores";
        }
        ?>
    </form>

    <?php
    $errores = [];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $colores_seleccionados = [];
        for ($i = 1; $i <= $n_jugadores; $i++) {
            $nombre_jugador = htmlspecialchars(trim($_POST['jugadores']['jugador' . $i]['nombre']));
            $color_jugador = htmlspecialchars($_POST['jugadores']['jugador' . $i]['color']);
            if (empty($nombre_jugador)) {
                $errores[] = "El nombre del jugador $i está vacío.";
            }
            if (in_array($color_jugador, $colores_seleccionados)) {
                $errores[] = "El color seleccionado por el jugador $i ya ha sido elegido por otro jugador.";
            } else {
                $colores_seleccionados[] = $color_jugador;
            }

        }
        
        if (empty($errores)) {
            session_start();
            for ($i = 1; $i <= $n_jugadores; $i++) {
                $nombre = $_POST['jugadores']['jugador' . $i]['nombre'];
                $color = $_POST['jugadores']['jugador' . $i]['color'];
                $jugadores[$i] = ['nombre' => $nombre, 'color' => $color, 'posicion' => 1];
            }
            $_SESSION['jugadores'] = $jugadores;

            header('Location: juego.php');
            exit();
        }
    }
    ?>

    <?php
    if (!empty($errores)) {
        echo "<ul>";
        foreach ($errores as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
    ?>
</body>

</html>