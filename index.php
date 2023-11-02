<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

include('includes/conexion.php');
conectar();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Concurso de disfraces de Halloween</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="index.php">Ver Disfraces</a></li>
            <li><a href="index.php?modulo=procesar_registro">Registro</a></li>
            <li><a href="index.php?modulo=procesar_login">Iniciar Sesión</a></li>
            <li><a href="index.php?modulo=procesar_disfraz">Panel de Administración</a></li>
        </ul>
    </nav>
    <header>
        <h1>Concurso de disfraces de Halloween</h1>
        <?php
        if (isset($_SESSION['nombre_usuario'])){
            ?>
            <div class="sesion"><p><?php echo$_SESSION['nombre_usuario']?> , Usted tiene el ID: <?php echo $_SESSION['id'];?></p> </div>
            <a href="index.php?modulo=procesar_login&salir=ok">Salir </a>
            <?php 
        
        } ?> 
    </header>
    <main>
        <?php
        if (!empty($_GET['modulo'])) {
            include('modulos/' . $_GET['modulo'] . '.php');
        } else {
            $sql = "SELECT * FROM disfraces ORDER BY votos";
            $sql = mysqli_query($con, $sql);
            if (mysqli_num_rows($sql) != 0) {
                ?>
                <section id="disfraces-list" class="section">
                    <?php
                    while ($r = mysqli_fetch_assoc($sql)) {
                        ?>
                        <div class="disfraz">
                            <h2>
                                <?php echo $r['nombre']; ?>
                            </h2>
                            <p>
                                <?php echo $r['descripcion']; ?>
                            </p>
                            <p>Votos:
                                <?php echo $r['votos']; ?>
                            </p>
                            <p><img src="imagenes/<?php echo $r['foto']; ?>" width="100%"></p>
                                <?php
                                if (!empty($_SESSION['nombre_usuario'])) {
                                $sql_votos= "SELECT *FROM votos where id_disfraz=".$r['id']." and id_usuario=".$_SESSION['id'];
                                $sql_votos= mysqli_query($con, $sql_votos);
                                if (mysqli_num_rows($sql_votos)== 0){
                                    ?>
                                    <button class="votar">Votar </button>
                                    <?php
                                }
                            }
                                ?>
                        </div>
                        <hr>
                        <?php


                    }
                    ?>
                </section>
                <?php

            } else {
                ?>
                <section id="disfraces-list" class="section">
                    <!-- Aquí se mostrarán los disfraces -->
                    <div class="disfraz">
                        <h2>No hay datos</h2>
                    </div>
                    <hr>

                </section>
                <?php
            }
        }
        ?>



    </main>
    <script src="js/script.js"></script>
</body>

</html>