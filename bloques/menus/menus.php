<?php include("includes/acceso.php"); ?>
<?php
//$Saltar = new Saltar();

// Acceso a Datos
include_once("datos/datos_menu.php");
$Elementos_sueltos = new Datos_menu();
$Categoria = new Datos_menu();
$Asignaciones = new Datos_menu();
$Elementos_sueltos->Mostrar_elementos_sueltos();
$Categoria->Mostrar_categorias();
// Calculos y procesos
// Ejentos Ajenos
if($_POST['actualizar_elemento']){
	$Categoria->Actualizar_elemento($_POST['id'],$_POST['nombre'],$_POST['activo'],$_POST['url'],$_POST['tipo'],$_POST['funciones'],$_POST['descripcion']);
}



if($_POST['guardar_elemento']){
	$Categoria->Guardar_elementos($_POST['nombre'],$_POST['activo'],$_POST['url'],$_POST['tipo'],$_POST['funciones'],$_POST['descripcion']);
	
}

if($_POST['guardar_nueva_cat']){
	$Categoria->Guardar_categoria($_POST['nombre'],$_POST['descripcion'],$_POST['id_elemento_suelto'], $_POST['clase']);
}

if($_POST['guardar_editar_cat']){
	$Categoria->Actualizar_elementos($_POST['id'],$_POST['nombre'],$_POST['descripcion'],$_POST['id_elemento_suelto'],$_POST['clase']);
}

if($_POST['crear_asignacion']){
	$Categoria->Crear_asignacion($_POST['id_usuario'],$_POST['id_m_categoria']);
}

if ($_POST['quitar_asignacion']){
	$Categoria->Quitar_asignacion($_POST['id_m_u']);
}

// Eventos Propios
if($_POST['nuevo_grupo']){
	include_once("bloques/menus/nueva_asignacion.php");
	//exit();
	//terminar_app();
    $SaltarMenu = true;
    goto IrAlFinal;

//    goto IrAlPie;
//    $Saltar->Cuerpo(true);
}

if($_POST['nueva_categoria']){
	include_once("bloques/menus/nueva_categoria.php");
	//exit();
//    $Saltar->SaltarMenu();
    ClassSaltar::SaltarMenu();
    goto IrAlFinal;
//    goto IrAlPie;
}

if($_POST['editar_categoria']){
	include_once("bloques/menus/editar_categoria.php");
    ClassSaltar::SaltarMenu();
    goto IrAlFinal;
}

if($_POST['nuevo_elemento']){
	include_once("bloques/menus/nuevo_elemento.php");
	//exit();
    ClassSaltar::SaltarMenu();
    goto IrAlFinal;
//    $Saltar->Cuerpo(true);
//    goto IrAlPie;
}

if($_POST['editar_elemento']){
	include_once("bloques/menus/editar_elemento.php");
	//exit();
    ClassSaltar::SaltarMenu();
    goto IrAlFinal;
//    $Saltar->Cuerpo(true);
//    goto IrAlPie;
}

$Asignaciones->Mostrar_asignacion();
$Elementos_sueltos->Mostrar_elementos_sueltos();
$Categoria->Mostrar_categorias();

//if($Saltar->saltar_cuerpo == false) {
    ?>
    <style type="text/css">
        <!--
        .texto_derecha {
            text-align: right;
            font-size: 11px;
        }

        .pexto_peque {
            font-family: "Courier New", Courier, monospace;
            font-size: 11px;
        }

        -->
    </style>
    <form name="form1" method="post" action="">
        <table width="100%" border="1" class="pexto_peque">
            <tr>
                <th colspan="3">Acceso S&oacute;lamente a Administradores</th>
            </tr>
            <tr>
                <th width="29%">Elementos Sueltos</th>
                <th width="18%">Categorias de Menus</th>
                <th width="53%">Asignaci&oacute;n de Usuarios</th>
            </tr>
            <tr>
                <td>
                    <?php
                    for ($i = 0; $i < $Elementos_sueltos->num_filas; $i++) {
                        echo "<input name='id_elemento_suelto' type='radio' value='" . $Elementos_sueltos->datos[$i]->id_menu . "' />";
                        echo $Elementos_sueltos->datos[$i]->nombre;
                        echo "<br>";
                    }

                    ?></td>
                <td><?php
                    for ($i = 0; $i < $Categoria->num_filas; $i++) {
                        echo "<input name='id_m_categoria' type='radio' value='" . $Categoria->datos[$i]->id_m_categoria . "' />";
                        echo $Categoria->datos[$i]->nombre;
                        echo "<br>";
                    }

                    ?></td>
                <td><?php
                    $temp = 0;
                    $temp_estado_a = 0;
                    $temp_estado_b = 0;
                    for ($i = 0; $i < $Asignaciones->num_filas; $i++) {
                        if ($temp_estado_a != $Asignaciones->datos[$i]->id_usuario) {
                            $temp_estado_a = $Asignaciones->datos[$i]->id_usuario;
                            echo "<fieldset>";
                        }
                        echo "<input name='id_m_u' type='radio' value='" . $Asignaciones->datos[$i]->id_m_u . "' />";
                        echo $Asignaciones->datos[$i]->nombres . " " . $Asignaciones->datos[$i]->ape_pat . " " . $Asignaciones->datos[$i]->ape_mat . " -> " . $Asignaciones->datos[$i]->usuario . " -> " . $Asignaciones->datos[$i]->cargo . " -> " . $Asignaciones->datos[$i]->nombre_cat . "<br>";
                        if ($Asignaciones->datos[$i]->id_usuario != $Asignaciones->datos[$i + 1]->id_usuario) {
                            echo "</fieldset><br>";
                        }

                    }

                    ?></td>
            </tr>
            <tr>
                <th>
                    <input name="nuevo_elemento" type="submit" id="nuevo_elemento" value="Nuevo Elemento">
                    <br>
                    <input name="editar_elemento" type="submit" id="editar_elemento" value="Editar Elemento">
                </th>
                <th><input name="nueva_categoria" type="submit" id="nueva_categoria" value="Nueva Categor&iacute;a">
                    <br>
                    <input name="editar_categoria" type="submit" id="editar_categoria" value="Editar Categor&iacute;a">
                </th>
                <th><input name="nuevo_grupo" type="submit" id="nuevo_grupo" value="Nueva Asignacion">
                    <br>
                    <input name="quitar_asignacion" type="submit" id="editar_grupo" value="Quitar Asignaci&oacute;n">
                    <br></th>
            </tr>
            <tr>
                <td>Los elementos sueltos hacen referencia dir&eacute;ctamente a los elementos creados, solo accesible
                    por el Super Administrador
                </td>
                <td>Grupos de men&uacute;s que permiten diferenciar un tipo de usuarios de otro, s&oacute;lamente
                    accesible por el Super Administrador
                </td>
                <td>Una vez que se crean los usuarios se debe poner como miembro de una categor&iacute;a y agruparlos
                    seg&uacute;n el permiso.
                </td>
            </tr>
        </table>
    </form>
    <?php
   IrAlFinal:
?>
