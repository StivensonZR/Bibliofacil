<?php
    session_start();

    if(!isset($_SESSION['usuario'])){
        header("location: index.html");
        
    }    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>BiblioFacil | Principal</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/hojaEstilos_principal_02.css">
    <link rel="stylesheet" href="fonts/style.css">
    <link href = "https://fonts.googleapis.com/css2? family = Sansita + Swashed: wght @ 600 & display = swap" rel = "stylesheet">
    <!--<link href="https://fonts.googleapis.com/css2?family=Merienda&family=Roboto&display=swap" rel="stylesheet">-->
    <script src="js/jquery-3.5.1.js"></script> 
</head>

<body>
    <header>
     <h1> <span class="icon-library"> <td></td> </span>BIBLIOFÁCIL</h1>
      <input type="checkbox" id="btn-menu">
      <label for="btn-menu" class="icon-menu"></label>
       <nav class="menu">
           <ul>
               <li ><a href="#">Usuarios </a> 
                   <ul>     
                       <li><a href="nuevoUsuario.php">Nuevo Usuario</a></li>
                       <li><a href="editaUsuario.php">Editar Usuario</a></li>
                  </ul>                  
               </li>
               <li ><a href="#">Prestamos </a>    
                   <ul>
                       <li><a href="prestamosActuales.php">Prestamos actuales</a></li>
                       <li><a href="">Disponibilidad</a></li>
                       <li><a href="nuevoPrestamo.php">Nuevo prestamo</a></li>

                   </ul>
               </li>
               <li ><a href="#">Libros </a> 
                   <ul>
                       <li><a href="nuevoLibro.php">Nuevo Libro</a></li>
                       <li><a href="nuevoEjemplar.php">Nuevo Ejemplar</a></li>
                       <li><a href="editaLibro.php">Editar Libro</a></li>
                   </ul>
               </li>
               <li ><a href="#">Tramites </a>             
                   <ul>                      
                       <li><a href="Multa.php">Multa</a></li>
                       <li><a href="PazySalvo.php">Paz y Salvo</a></li>
                   </ul>
               </li>
               <li ><a href="#"> &nbsp; <span class = "icon-user"></span> </a>
                   <ul>
                       <li><a href="newAdmin.php">New Admin</a></li>
                       <li><a href="ayuda.html">Ayuda</a></li>
                       <li><a href="php/salir.php">Salir</a></li>
                   </ul>
               </li>
             
           </ul>
       </nav>
    </header>
    
    <script src="js/principal_02.js"></script> 
       
    <div>
        <div class="tab">
    
            <img id="img" src="imagenes/Escudo-Colegio_1.png" alt="Escudo Colegio">
            
            <h2><span class="icon-history"></span>Nosotros</h2>

            <a href="Principal.php" id="actual"><h4>Historía</h4></a>

            <a href="mision.php"><h4>Misión</h4></a>
            
            <a href="vision.php"><h4>Visión</h4></a>
            
           <p>
               Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore animi similique distinctio aut quasi laborum, eveniet suscipit unde quia ullam tenetur eos maiores iure quos aliquam vel adipisci, ex veritatis rem recusandae numquam quod! Eligendi, commodi? Quaerat, suscipit nihil dolores provident tenetur, consequatur praesentium minus aspernatur accusantium obcaecati amet quo iusto! Esse ea vero illo corrupti sequi iure quasi! Dolores vero error dolor id distinctio blanditiis unde iste vitae sequi corrupti ratione eos dolorum alias ullam libero officiis assumenda officia reiciendis eaque quasi adipisci labore, rem facere. Ut asperiores enim ullam repudiandae distinctio corrupti, reiciendis eum perspiciatis ex incidunt deleniti repellat tenetur dolor cum natus fugit provident suscipit excepturi nulla veritatis vel harum doloribus explicabo illo. Dolores impedit recusandae cum voluptatum voluptatibus doloremque quo quasi quidem quae facere saepe, illum magnam voluptates neque nam itaque aliquam odit atque quibusdam ullam a similique. Expedita officiis similique numquam deserunt? Sequi vel voluptatibus et quisquam, dolore ea consequatur molestias sed dolor deleniti nulla sit fugit, amet doloremque aperiam accusamus? Suscipit assumenda iusto doloremque quo ratione, dolor cupiditate recusandae! Numquam, natus omnis quibusdam doloremque eum dolor temporibus assumenda laudantium, minus aliquam aut architecto id sunt dolorem repudiandae nulla fugit iure nihil, voluptatum qui et!
            </p>
        </div>

        <div class="tab">
            <h2><span class="icon-history"></span>Nuestros Valores</h2>
            
            <div class="valores">
                <h4>Compromiso</h4>
                   <br>
                   <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero placeat accusantium eligendi tempora voluptate officiis nobis iure, inventore, blanditiis esse optio autem a tempore qui exercitationem! Blanditiis deleniti consectetur veritatis facilis modi eaque dolore sapiente, eius harum voluptates sequi numquam corporis minima, ipsam possimus neque placeat fuga iusto laudantium aliquam?</p>
            </div>
            
            <div class="valores">
               <h4>Responsabilidad Social</h4>
                   <br>
                   <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero placeat accusantium eligendi tempora voluptate officiis nobis iure, inventore, blanditiis esse optio autem a tempore qui exercitationem! Blanditiis deleniti consectetur veritatis facilis modi eaque dolore sapiente, eius harum voluptates sequi numquam corporis minima, ipsam possimus neque placeat fuga iusto laudantium aliquam?</p>
            </div>
            <div class="valores">
                <h4>Transformación</h4>  
                     <br>
                     <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero placeat accusantium eligendi tempora voluptate officiis nobis iure, inventore, blanditiis esse optio autem a tempore qui exercitationem! Blanditiis deleniti consectetur veritatis facilis modi eaque dolore sapiente, eius harum voluptates sequi numquam corporis minima, ipsam possimus neque placeat fuga iusto laudantium aliquam?</p>
            </div>
        </div>   
    </div> 

</section>  
<br><br><br>
        
<footer class="footer" >
<p>
    &copy; 2021 BIBLIOFÁCIL <br>
    Todos los derechos reservados
</p>
</footer>

</body>
</html>
