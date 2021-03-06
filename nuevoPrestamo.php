<?php
require_once('php/Conexion_bd.php');

/*
Solucionar que al enviar el formulario vacio, no se inserte nada.
Mejorar la visibilidad del formulario
*/

/*if(isset( $_POST['id_usuario'], $_POST['id_libro'], $_POST['id_administrador'], $_POST['fecha_inicio'],$_POST['fecha_fin']) 
        &&
        $_POST['id_usuario'] != "" && $_POST['id_libro'] != "" && $_POST['id_administrador'] != "")       
{ */
    
   /* if(isset( $_POST['id_usuario'], $_POST['id_administrador'], $_POST['fo_ejemplar'], $_POST['fecha_inicio'],$_POST['fecha_fin']) 
    &&
    $_POST['id_usuario'] != "" && $_POST['id_administrador'] != "")       
{*/

if($_POST){

        $insercion_sql = 'INSERT INTO prestamos
        (fo_usuario, fo_ejemplar, fo_libro_e, fo_administrador, fecha_pres, fecha_venc)
        VALUES(?,?,?,?,?,?)';
        
        //VARIABLES QUE TOMAN LA INFORMACION RELACIONADA EN LOS CAMPOS
        
        $id_usuario = isset( $_POST['id_usuario'] ) ? $_POST['id_usuario']: ''; 
        $id_ejemplar = isset( $_POST['fo_ejemplar'] ) ? $_POST['fo_ejemplar']: ''; 
        $id_libro_e = isset( $_POST['fo_libro_e'] ) ? $_POST['fo_libro_e']: ''; 
        $id_administrador = isset( $_POST['id_administrador'] ) ? $_POST['id_administrador']: ''; 
        $fecha_inicio = isset( $_POST['fecha_inicio'] ) ? $_POST['fecha_inicio']: ''; 
        $fecha_fin = isset( $_POST['fecha_fin'] ) ? $_POST['fecha_fin']: ''; 
        
        $declaracion_insert = $pdo->prepare($insercion_sql);
        $declaracion_insert -> execute(array($id_usuario, $id_ejemplar, $id_libro_e, $id_administrador, $fecha_inicio, $fecha_fin));


        //echo var_dump($declaracion_insert);
}

$fecha = date('Y-m-d');
$dia_ant = strtotime($fecha."- 1 days");
$dia_ant1 = date("Y-m-d", $dia_ant);
$dia_sig = strtotime($fecha."+ 15 days");
$dia_sig1 = date("Y-m-d", $dia_sig);


$disponiblidad_libros = "SELECT L.id_libro AS id_libro, C.categoria AS categoria, L.nombre AS nombre
                        FROM libro AS L
                        INNER JOIN categoria AS C
                        ON L.fo_categoria = C.id_categoria
                        WHERE L.estado = 1 ";


$arreglo = array();

//CONTEO PARA LA GENERACION DE LAS PAGINAS
$sentencia_conteo = $pdo->prepare($disponiblidad_libros);
$sentencia_conteo->execute($arreglo);
$resultado_sin_paginar = COUNT($sentencia_conteo->fetchAll());

$filas_a_mostrar = 20;

$total_paginas_a_mostrar = ceil($resultado_sin_paginar/$filas_a_mostrar);

$pagina_actual = isset($_GET['page']) ? $_GET['page'] : 0; 
$parametro_pagina_sql = $pagina_actual * $filas_a_mostrar;

$disponiblidad_libros .= " LIMIT {$parametro_pagina_sql},{$filas_a_mostrar}";

//var_dump($disponiblidad_libros);

$disponibilidad=$pdo->prepare($disponiblidad_libros);
$disponibilidad->execute($arreglo);
$resultado = $disponibilidad->fetchAll();


?>
<!DOCTYPE html>
<html>
   
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>BiblioFacil | Nuevo Prestamo</title>
        <link rel="stylesheet" href="fonts/style.css">
        <link rel="stylesheet" href="css/hojaEstilos_prestamos.css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
        <script src="js/jquery-3.5.1.js"></script> 
    </head>
    
<body>
    <header>
     <h1 class="h1">BIBLIOF??CIL</h1>
      <input type="checkbox" id="btn-menu">
      <label for="btn-menu" class="icon-menu"></label>
       <nav class="menu">
           <ul>
                <li class = "submenu" ><a href="Principal.php">Principal
                   <span class="icon-home"></span></a>
                </li>
           </ul>
       </nav> 
    </header>
    <script src="js/principal_02.js"></script> 
       
    <div class="div_formulario">
        <form method="post" class="form">    
        <p>
            <span class="icon-book"> Registro Prestamo </span>
        </p>
            <table>
                <tr>
                    <td>Id Usuario:</td>
                    <td><label for="id_usuario"></label>
                    <input type="text" name="id_usuario" id="id_usuario" required="required">*</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Id Administrador:</td>
                    <td><label for="id_administrador"></label>
                    <input type="text" name="id_administrador" id="id_administrador" required="required">*</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Id Ejemplar:</td>
                    <td><label for="fo_ejemplar"></label>
                    <input type="text" name="fo_ejemplar" id="fo_ejemplar" required="required">*</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Id Libro:</td>
                    <td><label for="fo_ejemplar"></label>
                    <input type="text" name="fo_libro_e" id="fo_libro_e" required="required">*</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Fecha Inicio:</td>
                    <td><label for="fecha_inicio"></label>
                    <input type="date" name="fecha_inicio" step="1" min="<?php echo $dia_ant1;?>" max="<?php echo $fecha;?>" value ="Fecha Inicio" id="fecha_inicio" required="required">*</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Fecha Fin:</td>
                    <td><label for="fecha_fin"></label>
                    <input type="date" name="fecha_fin" step="1"  min="<?php echo $fecha ?>" max="<?php echo $dia_sig1 ?>" value ="Fecha Fin" id="fecha_fin" required="required">*</td>
                </tr>
                
            </table>
    
            <input type="submit"  value="Registrar" name="enviar" id="enviar">
        </form>
    </div>
    <div class="div1">
        <table class="table1">
            <thead>
                <tr id = "titulo_t1">
                    <th>Id</th><th>Categoria</th><th>Nombre</th>
                </tr>
            </thead>
            <tbody>
              <?php
                  foreach($resultado as $rs)
                  {  
              ?>
              <tr>
                  <td><?php echo $rs['id_libro']; ?></td>
                  <td><?php echo $rs['categoria']; ?></td>
                  <td><?php echo $rs['nombre']; ?></td>
                  
              </tr>

              <?php
                  }
              ?>
            </tbody>
        </table>
        <div id='boton_paginado'>
            <?php
                for($i = 1; $i <= $total_paginas_a_mostrar; $i++ )
                    { 
            ?>
                    <li id="li" ><a id="paginado" href="nuevoPrestamo.php?page=<?php echo $i-1;?>" aria-label="page <?php echo $i;?>"> <?php echo $i;?> </a></li>
            <?php
                    }

            ?>
        </div>
    </div>
    <td>&nbsp;</td>
    <footer class="footer" >
        <p>
            &copy; 2021 BIBLIOF??CIL <br>
            Todos los derechos reservados
        </p>
        </footer>
</body>
</html>