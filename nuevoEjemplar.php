<?php
require_once('php/Conexion_bd.php');

if ($_POST){ 
    //SENTENCIA SQL DE INSERCION DE LA INFORMACION INGRESADA POR EL ADMINISTRADOR

    $insercion_sql = 'INSERT INTO ejemplar
                (id_ejemplar, fo_libro, observaciones, ubicacion)
                VALUES(?,?,?,?)';

    //VARIABLES QUE TOMAN LA INFORMACION RELACIONADA EN LOS CAMPOS

    $ejemplar = isset($_POST['id_ejemplar']) ? $_POST['id_ejemplar'] : '';
    $libro = isset($_POST['fo_libro']) ? $_POST['fo_libro'] : '';
    $observaciones = isset($_POST['observaciones']) ? $_POST['observaciones'] : '';
    $ubicacion = isset($_POST['ubicacion']) ? $_POST['ubicacion'] : '';

    $declaracion_insert = $pdo->prepare($insercion_sql);
    $declaracion_insert->execute(array($ejemplar, $libro, $observaciones, $ubicacion));


    //echo var_dump($declaracion_insert);

}

$select_sql_libro = 'SELECT id_libro, nombre FROM libro
                    order by id_libro asc';

$sentencia_select_libro = $pdo->prepare($select_sql_libro);
$sentencia_select_libro->execute();
$resultado_a = $sentencia_select_libro->fetchAll();


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>BiblioFacil | Nuevo Ejemplar</title>
    <link rel="stylesheet" href="fonts/style.css">
    <link rel="stylesheet" href="css/hojaEstilos_nuevoLibro.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <script src="js/jquery-3.5.1.js"></script>
</head>

<body>
    <header>
        <h1 class="h1">BIBLIOFÁCIL</h1>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu" class="icon-menu"></label>
        <nav class="menu">
            <ul>
                <li class="submenu"><a href="Principal.php">Principal
                        <span class="icon-home"></span></a>
                </li>
            </ul>
        </nav>
    </header>
    <script src="js/principal_02.js"></script>
            
    <div class="div1">
        <form method="post" class="form">
            <p>
                <span class="icon-book"> Registro Ejemplar </span>
            </p>
            <table>
                <tr>
                    <td>Id Ejemplar:</td>
                    <td><label for="Ejemplar"></label>
                        <input type="number" name="id_ejemplar" id="Ejemplar" required="required">*
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Id Libro:</td>
                    <td>
                        <label for="Libro"></label>
                        <input type="number" name="fo_libro" id="Libro" required="required">*
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                <tr>
                    <td>Observaciones:</td>
                    <td>
                        <label for="Observaciones"></label>
                        <input type="text" name="observaciones" id="observaciones" required="required">*
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Ubicacion:</td>
                    <td>
                        <label for="Ubicacion"></label>
                        <input type="text" name="ubicacion" id="ubicacion" required="required">*
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <input type="submit" value="Registrar" name="enviar" id="enviar">
        </form>
    </div>

    <div class="div2">
        <table class="table1">
            <thead>
                <tr id="titulo_t1">
                    <th>Id</th>
                    <th>Nombre</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($resultado_a as $res_a) {
                ?>
                    <tr>
                        <td><?php echo $res_a['id_libro'] ?></td>
                        <td><?php echo $res_a['nombre'] ?></td>
                        
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>


    <footer class="footer">
        <p>
            &copy; 2021 BIBLIOFÁCIL <br>
            Todos los derechos reservados
        </p>
    </footer>

</body>

</html>