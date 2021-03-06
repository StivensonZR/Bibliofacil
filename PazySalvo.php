<?php
require_once('php/Conexion_bd.php');

$usuariosps = "SELECT id_usuario, nombres, apellidos, documento, identificacion, tipo_user, genero, paz_y_salvo FROM usuario
               INNER JOIN tipo_documento on tipo_documento.id_tipo = fo_tipo_doc
               INNER JOIN tipo_usuario on tipo_usuario.id_tipo = fo_tipo_user
               INNER JOIN genero on id_genero = fo_genero
               WHERE fo_estado = 1";

              // $usuariosps = "SELECT * from userspyz";

$usuario_buscado = isset($_GET['id']) ?$_GET['id'] : '';
$usuario_lista = explode(' ', $usuario_buscado);

$arreglo = array();

$l = 0;

foreach($usuario_lista as $usuario_busca)
{
    $usuariosps .=" AND id_usuario LIKE :search{$l}";
    $arreglo[":search{$l}"] = '%' . $usuario_busca . '%';
    $l++;
}

//CONTEO PARA LA GENERACION DE LAS PAGINAS
$sentencia_conteo = $pdo->prepare($usuariosps);
$sentencia_conteo->execute($arreglo);
$resultado_sin_paginar = COUNT($sentencia_conteo->fetchAll());

//echo $resultado_sin_paginar;

$filas_a_mostrar = 15;

$total_paginas_a_mostrar = ceil($resultado_sin_paginar/$filas_a_mostrar);

$pagina_actual = isset($_GET['page']) ? $_GET['page'] : 0; 

$parametro_pagina_sql = $pagina_actual * $filas_a_mostrar;

$usuariosps .= " LIMIT {$parametro_pagina_sql},{$filas_a_mostrar}";
$usuarios = $pdo->prepare($usuariosps);
$usuarios->execute($arreglo);
$resultado = $usuarios->fetchAll();
//echo var_dump($resultado);
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>BiblioFacil | Paz y Salvo</title>
        <link rel="stylesheet" href="css/hojaEstilos_pazysalvo.css">
        <link rel="stylesheet" href="fonts/style.css">
        <link rel="stylesheet" href="css/hojaEstilos_pazysalvo.css">
        <link href="https://fonts.googleapis.com/css2?family=Merienda&family=Roboto&display=swap" rel="stylesheet">
        <script src="js/jquery-3.5.1.js"></script> 
    </head>
    
    <body>
  
        <header>
            <h1>BIBLIOF??CIL</h1>
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
                <input id="buscar_caja" type="text" name = "id" placeholder = "Ingrese el ID del usuario" value = "<?php echo $usuario_busca; ?>">
                <input id="buscar_envio" type="submit" name:= "buscar"  value="Buscar" >
                </label>
            </form>   
         
            <section>
                <div class="div1">

                <table  class="table1">
                  <thead>
                   <tr  id="titulo_t2">
                        <th>Id</th><th> Nombres </th><th>Apellidos</th><th>Tipo Id</th>
                        <th>Identificaci??n</th><th>Tipo de usuario</th><th>Genero</th><th>Paz y Salvo</th>
                        <th>Generar P.S</th>
                   </tr>
                  </thead>


                  <tbody>
                    <?php
                        foreach($resultado as $rs)
                        {                  
                    ?>
                    <tr>                  
                        <td><?php echo $rs['id_usuario']; ?></td>               
                        <td><?php echo $rs['nombres']; ?></td>                
                        <td><?php echo $rs['apellidos']; ?></td>
                        <td><?php echo $rs['documento']; ?></td>
                        <td><?php echo $rs['identificacion']; ?></td>
                        <td><?php echo $rs['tipo_user']; ?></td>
                        <td><?php echo $rs['genero']; ?></td>
                        <td><?php echo $rs['paz_y_salvo']; ?></td>
                        <td> <a id="id" target="_blank" name="id" href="pazysalvoGenerado.php?id=<?php echo $rs['id_usuario'];?>"><?php if( $rs['paz_y_salvo'] == "S"){
                            echo("<span class='icon-file-text2'></span>");}?></a> 
                        </td>

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
                                <li id="li" ><a id="paginado" href="pazysalvo.php?page=<?php echo $i-1;?>" aria-label="page <?php echo $i;?>"> <?php echo $i;?> </a></li>
                        <?php
                                }

                        ?>
                    </div>
                    <br> 
                </div> 
                
            </section>  
        </div>       
        <footer class="footer" >
        <p>
            &copy; 2021 BIBLIOF??CIL <br>
            Todos los derechos reservados
        </p>
        </footer>
    </body>  
     
</html>  