<pre><?php
require_once('php/Conexion_bd.php');

//Sentencias que muestran la cantidad de libros existentes por categoria.


if($_POST)
{ 

    $actualizacion_sql = 'UPDATE detalle_prestamo
                        SET fecha_devuelto = now(), 
                        devuelto = "S"                     
                        WHERE fo_prestamo = ?';

        /*$actualizacion_sql = 'UPDATE prestamos
                              SET estado = 0, 
                              fecha_entrega = ?
                              WHERE id_prestamo = ?';*/
        
        //VARIABLES QUE TOMAN LA INFORMACION RELACIONADA EN LOS CAMPOS
        
        $id_prestamo = isset( $_POST['fo_prestamo'] ) ? $_POST['fo_prestamo']: ''; 
    
        $declaracion_update = $pdo->prepare($actualizacion_sql);
        $declaracion_update -> execute(array($id_prestamo));

        //var_dump($declaracion_update);  
}


$prestamos = 'SELECT P.id_prestamo AS Id_prestamo, concat(U.nombres," ",U.apellidos) AS nombre, L.nombre AS Nombre_Libro,
                P.fecha_pres AS Fecha_Prestamo, P.fecha_venc AS Fecha_Vencimiento 
                FROM usuario as U
                RIGHT JOIN prestamos AS P
                ON p.fo_usuario = U.id_usuario
                INNER JOIN ejemplar AS E
                ON (P.fo_ejemplar, fo_libro_e) = (E.id_ejemplar, E.fo_libro)
                RIGHT JOIN libro AS L
                ON E.fo_libro = L.id_libro
                WHERE P.estado = 1';
                
                /*prestamos AS P
                INNER JOIN usuario AS U
                ON P.fo_usuario = U.id_usuario
                INNER JOIN ejemplar AS E
                ON P.fo_ejemplar = E.id_ejemplar
                INNER JOIN libro AS L
                ON E.fo_libro = L.id_libro
                WHERE P.estado = 1';*/


$libro_p_buscado = isset($_GET['Nombre_Libro']) ?$_GET['Nombre_Libro'] : '';
$libro_p_lista = explode(' ', $libro_p_buscado);

$arreglo_1 = array();


$l = 0;

foreach($libro_p_lista as $libro_p_busca)
{
    $prestamos .=" AND L.nombre LIKE :search{$l}";
    $arreglo_1[":search{$l}"] = '%' . $libro_p_busca . '%';
    $l++;
}

//CONTEO PARA LA GENERACION DE LAS PAGINAS
$sentencia_conteo = $pdo->prepare($prestamos);
$sentencia_conteo->execute($arreglo_1);
$resultado_sin_paginar = COUNT($sentencia_conteo->fetchAll());

$filas_a_mostrar = 10;

$total_paginas_a_mostrar = ceil($resultado_sin_paginar/$filas_a_mostrar);

$pagina_actual = isset($_GET['page']) ? $_GET['page'] : 0; 

$parametro_pagina_sql = $pagina_actual * $filas_a_mostrar;
$prestamos .= " LIMIT {$parametro_pagina_sql},{$filas_a_mostrar}";
$prestamos_actuales=$pdo->prepare($prestamos);
$prestamos_actuales->execute($arreglo_1);
$resultado_p = $prestamos_actuales->fetchAll();


$fecha = date('Y-m-d');
$dia_ant = strtotime($fecha."- 1 days");

?>
</pre>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>BiblioFacil | Prestamos Actuales</title>
        <link rel="stylesheet" href="fonts/style.css">
        <link href="https://fonts.googleapis.com/css2?family=Merienda&family=Roboto&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/hojaEstilos_prestamosActuales.css">
        <script src="js/jquery-3.5.1.js"></script> 
    </head>
    
    <body>
  
        <header>
            <h1>BIBLIOFÁCIL</h1>
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
         
        <section>
           



                <div class="buscar" >
                    <!--<h3>Libros</h3>-->
                    <form id="buscar_form_1" method="get">
                        <label for="">
                        <input id="buscar_caja_1" type="text" name = "Nombre_Libro" placeholder = "Nombre del libro" value = "<?php echo $libro_p_busca; ?>">
                        <input id="buscar_envio_1" type="submit" name:= "buscar"  value="Buscar">
                        </label>
                    </form>
                    <table class="table2">
                        <thead>
                           <tr id="titulo_t2">
                                <th>Prestamo</th><th>Usuario</th><th>Nombre Libro</th>
                                <th>Fecha Prestamo</th><th>Fecha Vencimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($resultado_p as $rs_p)
                                {  
                            ?>
                                    <tr>
                                        <td><?php echo $rs_p['Id_prestamo']; ?></td>
                                        <td><?php echo $rs_p['nombre']; ?></td>
                                        <td><?php echo $rs_p['Nombre_Libro']; ?></td>
                                        <td><?php echo $rs_p['Fecha_Prestamo']; ?></td>
                                        <td><?php echo $rs_p['Fecha_Vencimiento']; ?></td>
                                    </tr>

                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                    <div id="boton_paginado">
                        <?php
                            for($i = 1; $i <= $total_paginas_a_mostrar; $i++ )
                                { 
                        ?>
                            <li id="li_1" >
                                <a id="paginado"  href="prestamosActuales.php?page=<?php echo $i-1;?>" aria-label="page <?php echo $i;?>"> 
                                    <?php echo $i;?> 
                                </a>
                            </li>
                        <?php
                                }

                        ?>
                    </div>


                    <div class="form_edita">
                    <form method="post"  id="formulario" class="form">    
                    <table>

                        <tr>
                            <td><b>Id Prestamo:</b></td>
                            <td><label for="id_usuario"></label>
                            <input type="number" name="fo_prestamo"  id="id_prestamos" required="required">*</td>
                        </tr>   
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        
                    </table>
                    <input type="submit" id="actualizar" value="Entregar">
                    <script src="js/EntregaLibro.js"></script>  
                    </form> 
                    <button id="muestra" onclick="muestraFormulario()">Entregar</button>
                </div>
                </div>   
            </div> 

</section>  
        
<footer class="footer" >
<p>
    &copy; 2021 BIBLIOFÁCIL <br>
    Todos los derechos reservados
</p>
</footer>

</body> 
</html>                                                        