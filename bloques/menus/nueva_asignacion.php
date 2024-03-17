<?php include("includes/acceso.php"); ?>
<?php
$Categoria = new Datos_menu();
$Usuario = new Datos_menu();
$Categoria->Mostrar_categorias();
$Usuario->Mostrar_usuarios();

?>
<form action="" method="post">
<table width="100%" border="1">
  <tr>
    <th colspan="3">Nueva Asignaci&oacute;n </th>
  </tr>
  <tr>
    <td>
    <?php
      for($i=0; $i<$Categoria->num_filas; $i++){
      		echo "<input name='id_m_categoria' type='radio' value='" . $Categoria->datos[$i]->id_m_categoria . "' />";
      		echo $Categoria->datos[$i]->nombre;
      		echo "<br>";
      }
      
      ?>
    </td>
    <td>==&gt;&gt;</td>
    <td><?php
      for($i=0; $i<$Usuario->num_filas; $i++){
      		echo "<input name='id_usuario' type='radio' value='" . $Usuario->datos[$i]->id_usuario . "' />";
      		echo $Usuario->datos[$i]->tipo_usuario . " -> " . $Usuario->datos[$i]->nombres . " " . $Usuario->datos[$i]->ape_pat . " " . $Usuario->datos[$i]->ape_mat;
      		echo "<br>";
      }
      
      ?></td>
  </tr>
  <tr>
    <th colspan="3"><input name="crear_asignacion" type="submit" id="crear_asignacion" value="Crear Asignaci&oacute;n"> <input type="submit" name="button" id="button" value="Cancelar" /></th>
  </tr>
</table>
</form>