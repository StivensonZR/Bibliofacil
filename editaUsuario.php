<?php
require_once('php/Conexion_bd.php');

if($_POST)
{ 

        $actualizacion_sql = 'UPDATE usuario
                              SET nombres = ?
                                  , apellidos = ?
                                  , fo_tipo_user = ?
                                  , fo_genero = ?
                                  , fecha_naci = ?
                                  , edad = ?
                                  , telefono = ?
                                  , email = ?
                                  , direccion = ?
                                  , fo_tipo_doc = ?
                                  , identificacion = ?
                                  , fo_estado = ?
                              WHERE id_usuario = ?';
        
        //VARIABLES QUE TOMAN LA INFORMACION RELACIONADA EN LOS CAMPOS
        
        $nombres = isset( $_POST['nombres'] ) ? $_POST['nombres']: ''; 
        $apellidos = isset( $_POST['apellidos'] ) ? $_POST['apellidos']: ''; 
        $fo_tipo_user = isset( $_POST['fo_tipo_user'] ) ? $_POST['fo_tipo_user']: '';       
        $fo_genero = isset( $_POST['fo_genero'] ) ? $_POST['fo_genero']: ''; 
        $fo_tipo_doc = isset( $_POST['fo_tipo_doc'] ) ? $_POST['fo_tipo_doc']: ''; 
        $edad = isset( $_POST['fecha_naci'] ) ? $_POST['fecha_naci']: ''; 
        $telefono = isset( $_POST['telefono'] ) ? $_POST['telefono']: ''; 
        $email = isset( $_POST['email'] ) ? $_POST['email']: ''; 
        $direccion = isset( $_POST['direccion'] ) ? $_POST['direccion']: ''; 
        $pasysalvo = isset( $_POST['pazysalvo'] ) ? $_POST['pazysalvo']: ''; 
        $identificacion = isset( $_POST['identificacion'] ) ? $_POST['identificacion']: ''; 
        $fo_estado = isset( $_POST['fo_estado'] ) ? $_POST['fo_estado']: '';     
        $id_usuario = isset( $_POST['id_usuario'] ) ? $_POST['id_usuario']: ''; 
    
        $declaracion_update = $pdo->prepare($actualizacion_sql);
        $declaracion_update -> execute(array($nombres, $apellidos, $fo_tipo_user, $fo_genero, $fo_estado, $pasysalvo, $fo_tipo_doc, $edad, $telefono, $email, $direccion, $identificacion, $id_usuario));
        var_dump($declaracion_update);
    
}


$usuarios_activos = "SELECT id_usuario, nombres, apellidos, tipo_user, genero, fo_estado, documento, 
                    identificacion, fecha_naci, edad, telefono, email, direccion, paz_y_salvo FROM usuario
                    INNER JOIN tipo_documento on tipo_documento.id_tipo = fo_tipo_doc
                    INNER JOIN tipo_usuario on tipo_usuario.id_tipo = fo_tipo_user
                    INNER JOIN genero on id_genero = fo_genero";

$usuario_buscado = isset($_GET['id']) ?$_GET['id'] : '';
$usuario_lista = explode(' ', $usuario_buscado);

$arreglo = array();


$l = 0;

foreach($usuario_lista as $usuario_busca)
{
    $usuarios_activos .=" WHERE id_usuario LIKE :search{$l}";
    $arreglo[":search{$l}"] = '%' . $usuario_busca . '%';
    $l++;
}

//CONTEO PARA LA GENERACION DE LAS PAGINAS
$sentencia_conteo = $pdo->prepare($usuarios_activos);
$sentencia_conteo->execute($arreglo);
$resultado_sin_paginar = COUNT($sentencia_conteo->fetchAll());

$filas_a_mostrar = 20;

$total_paginas_a_mostrar = ceil($resultado_sin_paginar/$filas_a_mostrar);

$pagina_actual = isset($_GET['page']) ? $_GET['page'] : 0; 

$parametro_pagina_sql = $pagina_actual * $filas_a_mostrar;
$usuarios_activos .= " LIMIT {$parametro_pagina_sql},{$filas_a_mostrar}";
$usuarios=$pdo->prepare($usuarios_activos);
$usuarios->execute($arreglo);
$resultado = $usuarios->fetchAll();

?>
<!DOCTYPE html>
<html>
   
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>BiblioFacil | Editar Usuario</title>
        <link rel="stylesheet" href="fonts/style.css">
        <link rel="stylesheet" href="css/hojaEstilos_editaUsario.css">
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
        
    <div class="div_formulario">
    <table class="table1">
        <thead>
         <tr id="titulo_t1">
              <th>Id</th><th>Nombres</th><th>Apellidos</th><th>Tipo Documento</th><th>Identificación</th>
              <th>Tipo Usuario</th><th>Genero</th><th>Edad</th><th>Telefono</th>
              <th>E-mail</th><th>Dirección</th><th>Estado</th>
         </tr>
        </thead>
        <tbody>
         
        <?php
        
            foreach($resultado as $rs)
            {        
        ?>
         
         
          <tr>
              <td><?php echo  $rs['id_usuario']; ?></td>
              <td><?php echo  $rs['nombres']; ?></td>
              <td><?php echo  $rs['apellidos']; ?></td>
              <td><?php echo  $rs['documento']; ?></td>
              <td><?php echo  $rs['identificacion']; ?></td>
              <td><?php echo  $rs['tipo_user']; ?></td>
              <td><?php echo  $rs['genero']; ?></td>
              <td><?php echo  $rs['edad']; ?></td>
              <td><?php echo  $rs['telefono']; ?></td>
              <td><?php echo  $rs['email']; ?></td>
              <td><?php echo  $rs['direccion']; ?></td>
              
              <td id="estado" ><?php if($rs['fo_estado'] == 1)
                        {
                            echo('Activo');
                        }
                        else
                        {
                            echo('Inactivo');
                        }
                   ?>
                </td>
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
            <li id="li" >
                <a id="paginado"  href="editaUsuario.php?page=<?php echo $i-1;?>" aria-label="page <?php echo $i;?>"> 
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
                
                    <td><b>Nombres:</b></td>
                    <td><label for="nombre"></label>
                    <input type="text" name="nombres" id="nombre" required="required">*</td>
                    
                    <td><b>Apellidos:</b></td>
                    <td><label for="apellidos"></label>
                    <input type="text" name="apellidos" id="apellidos" required="required">*</td>

                <td><b>Documento:</b></td>
                <td>
                    <label for="Tipo_Id"></label>
                    <select name="tipo_id" required="required">
                        <option value="0">-</option>
                        <option value="1">C.C</option>
                        <option value="2">T.I</option>
                        <option value="3">C.E</option>
                        <option value="4">T.E</option>
                    </select>
                </td>
                    <td><b>Identificación:</b></td>
                    <td><label for="identificación"></label>
                    <input type="text" name="identificación" id="identificacion" required="required">*</td>

                 <td><b>Usuario:</b></td>
                   <td>
                       <label for="tipo_usuario"></label>
                       <select name="tipo_usuario" required="required">
                           <option value="0">-</option>
                           <option value="1">Alumno</option>
                           <option value="2">Docente</option>
                       </select>
                   </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>       
                <td><b>Genero:</b></td>
                   <td>
                       <label for="genero"></label>
                       <select name="genero" required="required">
                           <option value="0">-</option>
                           <option value="1">Masculino</option>
                           <option value="2">Femenino</option>
                           <option value="3">Indefinido</option>
                       </select>
                   </td>       
                    <td><b>Télefono:</b></td>
                    <td><label for="telefono"></label>
                    <input type="text" name="telefono" id="telefono" required="required">*</td>
                
                    <td><b>Correo:</b></td>
                    <td><label for="email"></label>
                    <input type="text" name="email" id="email"></td>
                
                    <td><b>Dirección:</b></td>
                    <td><label for="direccion"></label>
                    <input type="text" name="dirección" id="direccion" required="required">*</td>
                    
                    <td><b>Estado:</b></td>
                <td>
                    <label for="estado"></label>
                    <select name="estado" >
                        <option value="0">-</option>
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                        <option value="3">Suspendido</option>
                        <option value="4">Multado</option>
                    </select>
                </td>
                
                </tr>
            </table>
            <input type="submit" id="actualizar" value="Actualizar">
            <script src="js/editaUsuario.js"></script>  
            </form> 
            <button id="muestra" onclick="muestraFormulario()">Editar</button>
        </div>  
    </div> 
 
            
<footer class="footer" >
<p>
    &copy; 2021 BIBLIOFÁCIL <br>
    Todos los derechos reservados
</p>
</footer>
</body>
</html>