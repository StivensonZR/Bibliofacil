<?php
	session_start();
	//session_unset();
	session_destroy();
	echo "<script>
        alert('BIBLIOFÁCIL: Hasta pronto');
        window.location = '../index.html'
    </script>";
	//header("location: ../index.html");

	//exit();
?>