<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<?php
session_start();

if (isset($_SESSION['jugadores'])) {
    if (!isset($_SESSION['turno'])) {
        $_SESSION['turno'] = 1;
    }

    $jugadores = $_SESSION['jugadores'];

    require_once('./clases/Tablero.php');
    $numero_jugadores = count($jugadores);
    $tableroOca = new Tablero($numero_jugadores);
    $numero_de_casillas = $tableroOca->get_cantidad_casillas();
    $casillas_especiales = $tableroOca->get_casillas_especiales();
?>

<?php
for ($casilla = 1; $casilla <= $numero_de_casillas; $casilla++) {
    $especial = in_array($casilla, $casillas_especiales);
    if ($casilla % 8 == 1) {
        echo '<div class="row">';
    }
    ?>
    <div class="col casilla <?= $especial ? 'casilla-especial' : '' ?>" id="casilla-<?= $casilla ?>">Casilla Nº <?= $casilla ?> <?= $especial ? 'es especial' : '' ?></div>
    <?php
    if ($casilla % 8 == 0) { ?>
        </div>
    <?php
    }
}
?>


    <table class="table">
        <thead>
            <tr>
                <th scope="col">Jugador</th>
                <th scope="col">Color</th>
                <th scope="col">Posición</th>
                <th scope="col">Botón</th>
                <th scope="col">Dados</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jugadores as $indice => $jugador) { ?>
                <tr>
                    <td><?= $jugador['nombre'] ?></td>
                    <td style="background-color: <?= $jugador['color'] ?>;"></td>
                    <td id="posicion-jugador-<?= $indice ?>">Posición: <?= $_SESSION['jugadores'][$indice]['posicion'] ?></td>
                    <td>
                        <?php if ($_SESSION['turno'] == $indice) { ?>
                            <button onclick="lanzar_dados(<?= $indice ?>)">Lanzar dados</button>
                        <?php } ?>
                    </td>
                    <td>
                        <span class="dado"></span>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

<?php
} else {
    echo "No hay jugadores en la sesión.";
}
?>

<style>
    @font-face {
        font-family: dado;
        src: url('dado.otf');
    }

    .dado {
        font-family: dado;
        font-size: 25px;
    }

    .casilla {
        padding: 50px;
        border: 1px solid;
    }

    table {
        margin-left: 25px;
    }

    .jugador {
        padding: 10px;
        width: 20px;
        height: 20px;
    }

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        <?php foreach ($jugadores as $indice => $jugador) { ?>
            ficha(<?= $jugador['posicion'] ?>, '<?= $jugador['color'] ?>');
        <?php } ?>
    });

    function ficha(posicion, color) {
        var fichaN = document.createElement('div');
        fichaN.classList.add('jugador');
        fichaN.style.backgroundColor = color;
        var posicionActual = document.querySelector('#casilla-' + posicion);
        posicionActual.appendChild(fichaN);
    }

    function lanzar_dados(indice) {
        var dado1 = Math.floor(Math.random() * 6) + 1;
        var dado2 = Math.floor(Math.random() * 6) + 1;
        $('.dado').text(dado1 + " " + dado2);
        var sumaDados = dado1 + dado2;

        $.ajax({
            type: "POST",
            url: "actualizar_posicion.php",
            data: {
                indice: indice,
                sumaDados: sumaDados
            },
            success: function(response) {
                $('#posicion-jugador-' + indice).text('Posición ' + response);

                console.log(response)
                /*
                setTimeout(() =>{
                    location.reload();
                },1000)
                */
                
            }
        });
    }
</script>
