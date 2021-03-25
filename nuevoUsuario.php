<?php
require_once('php/Conexion_bd.php');

if(isset($_POST['nombre'], $_POST['apellido'], $_POST['fo_tipo_doc'], $_POST['identificacion'], $_POST['fo_tipo_user'],
         $_POST['fo_genero'], $_POST['fecha_naci'], $_POST['telefono'], $_POST['email'], $_POST['direccion']))
{ 

//SENTENCIA SQL DE INSERCION DE LA INFORMACION INGRESADA POR EL ADMINISTRADOR

$insercion_sql2 = 'INSERT INTO usuario
                  (nombres, apellidos, fo_tipo_doc, identificacion, fo_tipo_user, fo_genero,
                  fecha_naci, telefono, email, direccion, paz_y_salvo, fecha_activacion, fo_estado)
                  VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)';

//VARIABLES QUE TOMAN LA INFORMACION RELACIONADA EN LOS CAMPOS

$nombres = isset( $_POST['nombre'] ) ? $_POST['nombre']: ''; 
$apellidos = isset( $_POST['apellido'] ) ? $_POST['apellido']: ''; 
$tipo_id = isset( $_POST['fo_tipo_doc'] ) ? $_POST['fo_tipo_doc']: ''; 
$identificacion = isset( $_POST['identificacion'] ) ? $_POST['identificacion']: ''; 
$tipo_usuario = isset( $_POST['fo_tipo_user'] ) ? $_POST['fo_tipo_user']: ''; 
$genero = isset( $_POST['fo_genero'] ) ? $_POST['fo_genero']: ''; 
$fecha_naci = isset( $_POST['fecha_naci'] ) ? $_POST['fecha_naci']: ''; 
$telefono = isset( $_POST['telefono'] ) ? $_POST['telefono']: ''; 
$email = isset( $_POST['email'] ) ? $_POST['email']: ''; 
$direccion = isset( $_POST['direccion'] ) ? $_POST['direccion']: ''; 
$pazysalvo = 'S';
$fecha_activacion = date('Y-m-d');
$estado_usuario = 1;


$declaracion_insert2 = $pdo->prepare($insercion_sql2);
$declaracion_insert2 ->execute(array($nombres, $apellidos, $tipo_id, $identificacion, $tipo_usuario, $genero,
                                    $fecha_naci, $telefono, $email, $direccion, $pazysalvo, $fecha_activacion, $estado_usuario));

//echo var_dump($declaracion_insert2);

}
?>

<!DOCTYPE html>
<html>
   
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>BiblioFacil | Nuevo Usuario</title>
        <link rel="stylesheet" href="fonts/style.css">
        <link rel="stylesheet" href="css/hojaEstilos_creaUsuario.css">
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
    
    <form method="post" class="form">    
    <p>
        <span class="icon-accessibility">  Registro Usuario </span>
    </p>
        <table>
            <tr>
                <td>Nombres</td>
                <td><label for="nombre"></label>
                <input type="text" name="nombre" id="nombre" required="required">*</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Apellidos</td>
                <td><label for="apellidos"></label>
                <input type="text" name="apellido" id="apellido" required="required">*</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
            <td>Tipo usuario</td>
               <td>              
                   <select name="fo_tipo_user" required="required"> 
                       <option value="0">-</option>
                       <option value="1">Estudiante</option>
                       <option value="2">Docente</option>                     
                   </select>
               </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>  
            <td>Tipo Documento</td>
            <td> 
              
                <select name="fo_tipo_doc" required="required">
                    <option value="0">-</option>
                    <option value="1">Tarjeta de Identidad</option>
                    <option value="2">T.I Extranjera</option>
                    <option value="3">Cedula de Ciudadania</option>
                    <option value="4">C.C Extranjera</option>
                </select>
            </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
             <tr>
                <td>Número Id</td>
                <td><label for="identificacion"></label>
                <input type="number" name="identificacion" id="identificacion" maxlength="11" required="required">*</td>
            </tr>
           <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
            <td>Genero</td>
            <td>
                <select name="fo_genero" id="genero" required="required">
                    <option value="0">-</option>
                    <option value="1">Masculino</option>
                    <option value="2">Femenino</option>
                    <option value="3">Indefinido</option>
                </select>
            </td>
                
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Fecha de nacimiento</td>
                <td><input type="date" name="fecha_naci" required="required">*</td>
            </tr>          
            <tr>
                <td>&nbsp;</td>
            </tr>                   
            <tr>
                <td>Télefono</td>
                <td><label for="telefono"></label>
                <input type="number" name="telefono" id="telefono" maxlength="11" required="required">*</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Correo</td>
                <td><label for="email"></label>
                <input type="text" name="email" id="email" required="required">*</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Dirección</td>
                <td><label for="direccion"></label>
                <input type="text" name="direccion" id="direccion" required="required">*</td>
            </tr>
            <tr>
                <td>
                    &nbsp;
                </td>                    
            </tr>
        </table>
        <input type="submit"  value="Registrar" name="enviar" id="enviar">
    </form>
    
    <footer class="footer" >
    <p>
        &copy; 2021 BIBLIOFÁCIL <br>
        Todos los derechos reservados
    </p>
    </footer>

</body>
</html>