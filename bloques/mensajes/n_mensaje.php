<?php include("includes/acceso.php"); ?>
<?php
// Acceso a Datos

// Calculos y procesos
include_once "componentes/texto_e/ckeditor.php";
	// Create class instance.
	$CKEditor = new CKEditor();
	// Path to CKEditor directory, ideally instead of relative dir, use an absolute path:
	//   $CKEditor->basePath = '/ckeditor/'
	// If not set, CKEditor will try to detect the correct path.
	$CKEditor->basePath = 'componentes/texto_e/';
	// Replace textarea with id (or name) "editor1".
	$CKEditor->replace("mensaje");
// Eventos Ajenos

// Eventos Propios
?>
<form name="form1" method="post" action="">
<fieldset><legend>Panel de Botones</legend>
<table width="80%" border="0" align="right" cellpadding="0" cellspacing="0">
    <tr>
      <th>&nbsp;</th>
      <th><input type="submit" name="cancelar" value="Cancelar" id="cancelar"></th>
      <th><input type="submit" name="enviar_mensaje" value="Enviar" id="enviar_mensaje"></th>
    </tr>
  </table>
</fieldset>
  <br />
  <br>
  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td>
      <fieldset>
		<legend>Mensaje</legend>
		<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td>
                <p>Asunto:
  <input type="text" name="asunto" id="asunto" />
                </p>
                <p><?php
				// Include CKEditor class.
				include_once "componentes/texto_e/ckeditor.php";
				// Create class instance.
				$CKEditor = new CKEditor();
				$CKEditor->basePath = 'componentes/texto_e/';
				$initialValue = "";
				$config['language'] = 'es';
				//$config['toolbar'] = 'Basic';
				echo $CKEditor->editor("mensaje", $initialValue, $config);
			?>&nbsp;</p></td>
              <td>
              <fieldset>
                <legend>Destinatarios</legend>
              Usuarios<br>
                <select name="usuarios[]" size="7" multiple id="usuarios[]">
                  	<?php
                  		$Mensaje->listar_usuarios();
                  		for($i=0; $i<$Mensaje->num_filas; $i++){
                  			echo "<option value='" . $Mensaje->datos[$i]->id_usuario . "'>" . $Mensaje->datos[$i]->nombres . " " . $Mensaje->datos[$i]->ape_pat . " " . $Mensaje->datos[$i]->ape_mat . "</option>";
                  		}
                  	?>
                </select>
                </fieldset>
              </td>
            </tr>
          </table>
      </fieldset>
      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
