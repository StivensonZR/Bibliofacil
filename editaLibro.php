<?php
require_once('php/Conexion_bd.php');

if($_POST)
{ 

        $actualizacion_sql = 'UPDATE libro
                              SET nombre = ?
                                  , fo_autor = ?
                                  , fo_editorial = ?
                                  , fo_categoria = ?
                                  , estado = ? 
                              WHERE id_usuario = ?';

        //VARIABLES QUE TOMAN LA INFORMACION RELACIONADA EN LOS CAMPOS
                
        $nombre = isset( $_POST['nombre'] ) ? $_POST['nombre']: ''; 
        $autor = isset( $_POST['fo_autor'] ) ? $_POST['fo_autor']: ''; 
        $editorial = isset( $_POST['fo_editorial'] ) ? $_POST['fo_editorial']: '';  
        $categoria = isset( $_POST['fo_categoria'] ) ? $_POST['fo_categoria']: '';     
        $estado = isset( $_POST['estado'] ) ? $_POST['estado']: '';  
        $id_libro = isset( $_POST['id_libro'] ) ? $_POST['id_libro']: ''; 

        $declaracion_update = $pdo->prepare($actualizacion_sql);
        $declaracion_update -> execute(array($nombre, $autor, $editorial, $categoria, $estado, $id_libro));
        
        /*var_dump($declaracion_update);*/
}

$libros = "SELECT id_libro, nombre, autor, editorial, categoria, estado FROM libro
                     INNER JOIN autor on autor.id_autor = fo_autor
                     INNER JOIN editorial on editorial.id_editorial = fo_editorial
                     INNER JOIN categoria on categoria.id_categoria = fo_categoria";

$libro_buscado = isset($_GET['id']) ?$_GET['id'] : '';
$libro_lista = explode(' ', $libro_buscado);

$arreglo = array();

$l = 0;

foreach($libro_lista as $libro_busca)
{
    $libros .=" WHERE id_libro LIKE :search{$l}";
    $arreglo[":search{$l}"] = '%' . $libro_busca . '%';
    $l++;
}



//CONTEO PARA LA GENERACION DE LAS PAGINAS

$sentencia_conteo = $pdo->prepare($libros);
$sentencia_conteo->execute($arreglo);
$resultado_sin_paginar = COUNT($sentencia_conteo->fetchAll());

$filas_a_mostrar = 20;

$total_paginas_a_mostrar = ceil($resultado_sin_paginar/$filas_a_mostrar);

$pagina_actual = isset($_GET['page']) ? $_GET['page'] : 0; 

$parametro_pagina_sql = $pagina_actual * $filas_a_mostrar;
$libros .= " LIMIT {$parametro_pagina_sql},{$filas_a_mostrar}";
$libross=$pdo->prepare($libros);
$libross->execute($arreglo);
$resultado = $libross->fetchAll();


$select_sql_autor = 'SELECT autor, id_autor 
                     FROM autor 
                     /*WHERE estado = 1 */
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
        <title>BiblioFacil | Libros</title>
        <link rel="stylesheet" href="fonts/style.css">
        <link rel="stylesheet" href="css/hojaEstilos_libros.css">
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

    <div class="buscar" >
        <form id="buscar_form" method="get">
            <label for="">
            <input id="buscar_caja" type="text" name = "id" placeholder = "Ingrese el ID del libro" value = "<?php echo $libro_busca; ?>">
            <input id="buscar_envio" type="submit" name:= "buscar"  value="Buscar" >
            </label>
        </form>   
    <div class="div_formulario">
    <table class="table1">
        <thead>
         <tr id="titulo_t2">
              <th>Id</th><th>Titulo</th><th>Autor</th><th>Editorial</th><th>Categoria</th>
              <th>Estado</th>           
         </tr>
        </thead>
        <tbody>
         
        <?php
        
            foreach($resultado as $rs)
            {        
        ?>
         
         
          <tr>
              <td><?php echo  $rs['id_libro']; ?></td>
              <td><?php echo  $rs['nombre']; ?></td>
              <td><?php echo  $rs['autor']; ?></td>
              <td><?php echo  $rs['editorial']; ?></td>
              <td><?php echo  $rs['categoria']; ?></td>
              <td><?php echo  $rs['estado']; ?></td>
              
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
            <li id="li" >
                <a id="paginado"  href="editaLibro.php?page=<?php echo $i-1;?>" aria-label="page <?php echo $i;?>"> 
                    <?php echo $i;?> 
                </a>
            </li>
        <?php
                }
        ?>
    </div> 
    
    </div>
        <div class="form_edita">
            <form method="post"  id="formulario" class="form">    
            <table>

                <tr>
                    <td><b>Id Libro:</b></td>
                    <td><label for="id_libro"></label>
                    <input type="number" name="id_libro" id="id_libro"></td>
                   
                    <td><b>Titulo:</b></td>
                    <td><label for="nombre"></label>
                    <input type="text" name="nombre" id="nombre"></td>
                    
                    <td><b>Autor:</b></td>
                    <td><label for="autor"></label>
                    <input type="number" name="fo_autor" id="fo_autor"></td>
                
                    <td><b>Editorial:</b></td>
                    <td><label for="editorial"></label>
                    <input type="number" name="fo_editorial" id="fo_editorial"></td>                   
                
                <tr>
                    <td>&nbsp;</td>
                </tr>
             
                    <td><b>Categoria:</b></td>
                    <td><label for="categoria"></label>
                    <input type="number" name="fo_categoria" id="fo_categoria"></td>

                    <td><b>Estado:</b></td>
                    <td><label for="estado"></label>
                    <input type="number" name="estado" id="estado"></td>
                
                    <!--<td><b>N?? Ejemplares:</b></td>
                    <td><label for="ejemplares"></label>
                    <input type="number" name="num_ejemplares" id="num_ejemplares"></td>
                
                    <td><b>Ubicaci??n</b></td>
                    <td><label for="ubicaci??n"></label>
                    <input type="text" name="ubicaci??n" id="ubicaci??n"></td>

                    <td><b>Observaciones</b></td>
                    <td><label for="observaciones"></label>
                    <input type="text" name="observaciones" id="observaciones"></td>-->
                </tr>

            </table>
            <input type="submit" id="actualizar" value="Actualizar">
            <script src="js/editaUsuario.js"></script>  
            </form> 
            <button id="muestra" onclick="muestraFormulario()">Editar</button>
        </div>  
    </div>         
    <td>&nbsp;</td>            
    <!--<div class="div2">
        <table class="table3">
            <thead>
                <tr>
                    <th>Autor</th><th>Id</th>
                </tr>
            </thead>
            <tbody>
               <?php
                
                    foreach($resultado_a as $res_a)
                    {
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
        <table class ="table3">
            <thead>
                <tr>
                    <th>Editorial</th><th>Id</th>
                </tr>
            </thead>
                        <tbody>
                <?php
                
                    foreach($resultado_e as $res_e)
                    {
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
        <table class = "table3">
            <thead>
                <tr>
                    <th>Categoria</th><th>Id</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                    foreach($resultado_c as $res_c)
                    {
                ?>
                   <tr>
                    <td><?php echo $res_c['categoria'] ?></td>
                    <td><?php echo $res_c['id_categoria'] ?></td>
                    
                </tr>
                <?php
                    }
                ?>*/
            </tbody>
        </table>
    </div>-->

          
<footer class="footer" >
<p>
    &copy; 2021 BIBLIOF??CIL <br>
    Todos los derechos reservados
</p>
</footer>

</body>
</html>