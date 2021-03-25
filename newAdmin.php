<?php
require_once('php/Conexion_bd.php');

if(isset($_POST['nombre'], $_POST['apellido'], $_POST['identificacion'], $_POST['fo_genero'], 
            $_POST['fecha_naci'], $_POST['telefono'], $_POST['email'], $_POST['direccion'], $_POST['clave']))
{ 
 
//SENTENCIA SQL DE INSERCION DE LA INFORMACION INGRESADA POR EL ADMINISTRADOR

$insercion_admin = 'INSERT INTO administrador
                  (nombres, apellidos, identificacion, fo_genero,
                  fecha_naci, telefono, email, direccion, clave, fecha_ingreso, fo_estado)
                  VALUES(?,?,?,?,?,?,?,?,?,?,?)';

//VARIABLES QUE TOMAN LA INFORMACION RELACIONADA EN LOS CAMPOS

$nombres = isset( $_POST['nombre'] ) ? $_POST['nombre']: ''; 
$apellidos = isset( $_POST['apellido'] ) ? $_POST['apellido']: '';  
$identificacion = isset( $_POST['identificacion'] ) ? $_POST['identificacion']: '';  
$genero = isset( $_POST['fo_genero'] ) ? $_POST['fo_genero']: ''; 
$fecha_naci = isset( $_POST['fecha_naci'] ) ? $_POST['fecha_naci']: ''; 
$telefono = isset( $_POST['telefono'] ) ? $_POST['telefono']: ''; 
$email = isset( $_POST['email'] ) ? $_POST['email']: ''; 
$direccion = isset( $_POST['direccion'] ) ? $_POST['direccion']: ''; 
$clave = isset( $_POST['clave'] ) ? $_POST['clave']: ''; 
$fecha_activacion = date('Y-m-d');
$estado_admin = 1;


$declaracion_insert = $pdo->prepare($insercion_admin);
$declaracion_insert ->execute(array($nombres, $apellidos, $identificacion, $genero, $fecha_naci, $telefono, 
                                    $email, $direccion, $clave, $fecha_activacion, $estado_admin));

//echo var_dump($declaracion_insert);

}
?>

<!DOCTYPE html>
<html>
   
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>BiblioFacil | Nuevo Administrador</title>
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
        <span class="icon-accessibility">  Registro Administrador </span>
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
                <input type="text" name="telefono" id="telefono"  maxlength="11" required="required">*</td>
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
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Password</td>
                <td><label for="password"></label>
                <input type="password" name="clave" id="clave" maxlength="15" required="required">*</td>
            </tr>
            <tr>
                <td>
                    &nbsp;
                </td>                    
            </tr>
        </table>
        <input type="submit" value="Registrar" name="enviar" id="enviar">
    </form>
    
    <footer class="footer" >
    <p>
        &copy; 2021 BIBLIOFÁCIL <br>
        Todos los derechos reservados
    </p>
    </footer>

</body>
</html>

