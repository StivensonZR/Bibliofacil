<?php
require_once('php/Conexion_bd.php');

if ($_POST) {
    //SENTENCIA SQL DE INSERCION DE LA INFORMACION INGRESADA POR EL ADMINISTRADOR

    $insercion_sql = 'INSERT INTO libro
                (nombre, fo_autor, fo_categoria, fo_editorial, 
                 estado, fecha_creacion)
                VALUES(?,?,?,?,?,?)';

    //VARIABLES QUE TOMAN LA INFORMACION RELACIONADA EN LOS CAMPOS

    $nombre = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $autor = isset($_POST['autor']) ? $_POST['autor'] : '';
    $editorial = isset($_POST['editorial']) ? $_POST['editorial'] : '';
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
    $estado_libro = 1;
    $fecha_activacion = date('Y-m-d');


    $declaracion_insert = $pdo->prepare($insercion_sql);
    $declaracion_insert->execute(array($nombre, $autor, $categoria, $editorial, $estado_libro, $fecha_activacion));

}

$select_sql_autor = 'SELECT autor, id_autor 
                     FROM autor 
                     /*WHERE estado = 1*/
                     ORDER BY id_autor ASC';

$sentencia_select_autor = $pdo->prepare($select_sql_autor);
$sentencia_select_autor->execute();
$resultado_a = $sentencia_select_autor->fetchAll();

$select_sql_categoria = 'SELECT categoria, id_categoria 
                     FROM categoria 
                     /*WHERE estado = 1*/ 
                     ORDER BY id_categoria ASC';

$sentencia_select_categoria = $pdo->prepare($select_sql_categoria);
$sentencia_select_categoria->execute();
$resultado_c = $sentencia_select_categoria->fetchAll();

$select_sql_editorial = 'SELECT editorial, id_editorial 
                     FROM editorial 
                     /*WHERE estado = 1*/ 
                     ORDER BY id_editorial ASC';

$sentencia_select_editorial = $pdo->prepare($select_sql_editorial);
$sentencia_select_editorial->execute();
$resultado_e = $sentencia_select_editorial->fetchAll();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>BiblioFacil | Nuevo Libro</title>
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
                <span class="icon-book"> Registro Libro </span>
            </p>
            <table class="tabla">
                <tr>
                    <td>Titulo:</td>
                    <td><label for="titulo"></label>
                        <input type="text" name="titulo" id="titulo" required="required">*
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Autor(es):</td>
                    <td>
                        <label for="autor"></label>
                        <input type="number" name="autor" id="autor" required="required">*
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                <tr>
                    <td>Editorial:</td>
                    <td>
                        <label for="editorial"></label>
                        <input type="number" name="editorial" id="editorial" required="required">*
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Categoria:</td>
                    <td>
                        <label for="categoria"></label>
                        <input type="number" name="categoria" id="categoria" required="required">*
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
                    <th>Autor</th>
                    <th>Id</th>
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($resultado_a as $res_a) {
                ?>
                    <tr>
                        <td><?php echo $res_a['autor'] ?></td>
                        <td><?php echo $res_a['id_autor'] ?></td>

                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <table class="table1">
            <thead>
                <tr id="titulo_t1">
                    <th>Editorial</th>
                    <th>Id</th>
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($resultado_e as $res_e) {
                ?>
                    <tr>
                        <td><?php echo $res_e['editorial'] ?></td>
                        <td><?php echo $res_e['id_editorial'] ?></td>

                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <table class="table1">
            <thead>
                <tr id="titulo_t1">
                    <th>Categoria</th>
                    <th>Id</th>
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($resultado_c as $res_c) {
                ?>
                    <tr>
                        <td><?php echo $res_c['categoria'] ?></td>
                        <td><?php echo $res_c['id_categoria'] ?></td>

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