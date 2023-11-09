<?php
if (isset($_POST["nombre"]) && isset($_POST["descripcion"]) && isset($_GET['guardar_editar'])) {

    //verifico que no exista el disfraz
    $sql = "SELECT *FROM disfraces where nombre = '" . $_POST['nombre'] . "'";
    $sql = mysqli_query($con, $sql);
    if (mysqli_num_rows($sql) != 0) {
        echo "<script> alert('EL DISFRAZ YA EXISTE EN LA BD');</script>";
    } else {

        //procesar la foto
        if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
            $nombre = explode('.', $_FILES['foto']['name']);
            $foto = time() . '.' . end($nombre);
            copy($_FILES['foto']['tmp_name'], 'imagenes/' . $foto);

            $image = $_FILES['foto']['tmp_name'];
            $imgContenido = addslashes(file_get_contents($image));
        }
        //fin de procesar la foto


        //inserto nuevo disfraz
        $sql = "INSERT INTO disfraces (nombre,descripcion, votos,foto,foto_blob) values ('{$_POST['nombre']}','{$_POST['descripcion']}',0,'{$foto}','{$imgContenido}')";

        $sql = mysqli_query($con, $sql);
        if (mysqli_error($con)) {
            echo "<script> alert('ERROR NO SE PUDO INSERTAR EL DISFRAZ);</script>";
        } else {
            echo "<script> alert('Disfraz cargado con exito');</script>";
        }
    }
}
//eliminar
if($_GET['accion']=='guardar_eliminar') {
    $sql= "UPDATE disfraces SET eliminado=1 WHERE id=".$_GET['id'];
    $sql = mysqli_query($con, $sql);
    if (!mysqli_error($con)) { 
        echo "<script> alert('Disfraz eliminado con exito');</script>";
    }else 
    echo "<script> alert('ERROR, no se pudo eliminar');</script>";
}
//editar
if($_GET['accion']=='guardar_editar') {
    $sql= "UPDATE disfraces SET nombre='{$_POST['nombre']}',descripcion='{$_POST['descripcion']}' WHERE id=".$_GET['id'];
    $sql = mysqli_query($con, $sql);
    if (mysqli_error($con)) { 
        echo "<script> alert('Disfrazz editado con exito');</script>";
    }else echo "<script> alert('ERROR, no se pudo editar');</script>";
}
?>


<section id="admin" class="section">
    <h2>Panel de Administración</h2>
    <?php
    if(isset($_GET['accion']))
    {
        $url='index.php?modulo=procesar_disfraz&accion=guardar_editar';
        $sql="SELECT * FROM disfraces WHERE id= ".$_GET['id'];
        $sql = mysqli_query($con, $sql);
        if (mysqli_num_rows($sql) != 0) {
            $r= mysqli_fetch_array($sql);
        }
    }
    else
        $url='index.php?modulo=procesar_disfraz';
    ?>
    <form action="index.php?modulo=procesar_disfraz" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre del Disfraz:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $r['nombre'];?>" required>

        <label for="disfraz-descripcion">Descripción del Disfraz:</label>
        <textarea id="descripcion" name="descripcion" required ><?php echo $r['descripcion'];?></textarea>

        <label for="disfraz-nombre">Foto:</label>
        <img src="imagenes/<?php echo $r['foto']?>" width="100" >
        <input type="file" id="foto" name="foto">
        <button type="submit">Agregar Disfraz</button>
    </form>
</section>

<section id="admin" class="section">
    <h2>Listado</h2>
    <table>
        <tr>
            <td>Item</td>
            <td>Nombre</td>
            <td>Opciones</td>
        </tr>
        <?php
        $sql= "SELECT id, nombre FROM disfraces WHERE eliminado=0 ORDER BY nombre";
        $sql= mysqli_query($con, $sql);
        if(mysqli_num_rows($sql) != 0) {
            while ($r = mysqli_fetch_array($sql)) {
                ?>
                <tr>
                    <td><?php echo $r['id'];?></td>
                    <td><?php echo $r['nombre'];?></td>
                    <td>
                        <a href="index.php?modulo=procesar_disfraz&accion=editar&id=<?php echo $r['id'];?>">Editar</a>
                        <a href="index.php?modulo=procesar_disfraz&accion=guardar_eliminar&id=<?php echo $r['id'];?>">Eliminar</a>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</section>