<?php include("includes/acceso.php"); ?>
<form name="form1" method="post" action="">
  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <th colspan="6" scope="col"><h2>Edici&oacute;n de Usuarios </h2></th>
    </tr>
    <tr>
      <th width="7%" scope="row">C.I.</th>
      <th width="38%">Nombre Completo </th>
      <th width="19%">Cargo</th>
      <th width="14%">Usuario</th>
      <th width="11%">Modificar</th>
      <th width="11%">Opci&oacute;n</th>
    </tr>
	<?php for($i=0;$i<$Usr->num_filas;$i++){ ?>
    <tr>
      <th><?php echo $Usr->datos[$i]->ci; ?></th>
      <th><?php echo $Usr->datos[$i]->nombres . " " . $Usr->datos[$i]->ape_pat . " " . $Usr->datos[$i]->ape_mat; ?></th>
      <th><?php echo $Usr->datos[$i]->cargo; ?></th>
      <th><?php echo $Usr->datos[$i]->usuario; ?></th>
      <th><a href="<?php echo "?" . $_SERVER['QUERY_STRING'] . "&usr=ed&id=" . $Usr->datos[$i]->id_usuario; ?>">Mod.</a></th>
      <th>
      <?
		if($Usr->datos[$i]->activo == 's'){
			echo "<a href=?" . $_SERVER['QUERY_STRING'] . "&usr=mo&id=" . $Usr->datos[$i]->id_usuario . ">Desact.</a>";
		}else{
			echo "<a href=?" . $_SERVER['QUERY_STRING'] . "&usr=ac&id=" . $Usr->datos[$i]->id_usuario . ">Activar</a>";
		}
      ?>
      
      </th>
    </tr>
	<?php } ?>
    <tr>
      <th colspan="6">&nbsp;</th>
    </tr>
  </table>
</form>

