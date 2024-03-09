<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <form action="jugadores.php" method="GET">
        <div>
            <h2>Numero de jugadores</h2>
            <?php
                include_once ('constantes_globales.php');
                for ($i=JUGADORES_MINIMOS; $i <= JUGADORES_MAXIMOS; $i++) { 
                    ?>
                        <input type="submit" value="<?=$i?>" name="n_jugadores" class="btn btn-primary btn-lg">
                    <?php
                }
                
            ?>
        </div>
    </form>
</body>
</html>