<?php

$usuario = $_POST['email'];
$contrasena = $_POST['password'];

//conexion a la base de datos

$conexion = mysqli_connect("localhost", "root", "root", "bibliofacil");
$consulta = "SELECT * FROM administrador WHERE email = '$usuario' AND clave = '$contrasena'";
$resultado = mysqli_query($conexion,$consulta);

$filas = mysqli_num_rows($resultado);

if($filas > 0){    
    session_start();
    $_SESSION['usuario'] = $_POST['email'];
    echo "<script>
        alert('BIBLIOFÁCIL: Bienvenido');
        window.location = '../Principal.php'
    </script>";
}else{
    header("location:../index.html");        
}

mysqli_free_result($resultado);
mysqli_close($conexion);

?>

