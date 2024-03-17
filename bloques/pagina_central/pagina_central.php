<?php include("includes/acceso.php"); ?>
<?php
// Acceso a Datos
include_once 'datos/mensaje.php';
include_once 'datos/usuario.php';

$Usuario = new Usuario();
$Mensaje = new mensaje();

$Varios = new D_menu(); 
// Calculos y procesos

// Eventos Ajenos

// Eventos Propios
$Usuario->creado_por();
$Usuario->devolver_usuario_actual();


$sql = "show variables";
$Varios->select($sql);
?>
<script type="text/javascript" src="componentes/jquery/mootools-yui-compressed.js"></script>
<script type="text/javascript" src="componentes/jquery/sexyalertbox.v1.2.moo.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="componentes/jquery/sexyalertbox.css"/>
<script type="text/javascript">
function analisis_bdds(){
	Sexy.alert("<? 
		for($i=0; $i<20; $i++){
			echo $Varios->datos[$i]->Variable_name . " -> " . addslashes($Varios->datos[$i]->Value) . "<br>";
		}
	?>");
	}
</script>
<style type="text/css">
<!--
.texto_centro {
	text-align: center;
}

.borde_redondo {
border: 1px solid #069;
-moz-border-radius: 15px;
-webkit-border-radius: 15px;
padding: 10px;
background-color:#FFF;
height:auto;
background-image:url('imagenes/fondoa.jpg');
} 

-->
</style>
<form id="form2" name="form2" method="post" action="" >
<table width="95%" border="0" class="texto_centro">
  <tr>
    <td width="33%" valign="top"><div class="borde_redondo">
      <table width="100%" border="0" class="texto_centro">
        <tr>
          <td>Usuario<br />
            <img src="imagenes/Leopard Icon (60).png" alt="" width="70" height="70" /></td>
          </tr>
        <tr>
          <td><p>Bienvenido: <?php echo $Usuario->datos[0]->nombres . " " . $Usuario->datos[0]->ape_pat . " " .
                  $Usuario->datos[0]->ape_mat; ?></p></td>
          </tr>
      </table>
    </div></td>
    <td width="33%" valign="top"><div class="borde_redondo">
      <table width="100%" height="100%" border="0" class="texto_centro">
        <tr>
          <td>Mensajes<br />
            <img src="imagenes/Leopard Icon (109).png" alt="" width="70" height="70" /></td>
        </tr>
        <tr>
          <td><p>Mensajes sin revisar.</p></td>
        </tr>
      </table>
    </div></td>
    <td width="33%" valign="top"><div class="borde_redondo">
      <table width="100%" border="0" class="texto_centro">
        <tr>
          <td>Herramientas<br />
            <img src="imagenes/Leopard Icon (123).png" alt="" width="70" height="70" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td valign="top"><div class="borde_redondo">
      <table width="100%" border="0" class="texto_centro">
        <tr>
          <td>Estado de Turnos<br />
            <img src="imagenes/Leopard Icon (137).png" alt="" width="70" height="70" /></td>
        </tr>
        <tr>
          <td><p>--

              </p></td>
        </tr>
      </table>
    </div></td>
    <td valign="top"><div class="borde_redondo">
      <table width="100%" border="0" class="texto_centro">
        <tr>
          <td>Configuraci&oacute;n<br />
            <img src="imagenes/Leopard Icon (4).png" alt="" width="70" height="70" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
    </div></td>
    <td valign="top"><div class="borde_redondo">
      <table width="100%" border="0" class="texto_centro">
        <tr>
          <td>Reportes<br />
            <img src="imagenes/Leopard Icon (5).png" alt="" width="70" height="70" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td valign="top"><div class="borde_redondo">
      <table width="100%" border="0" class="texto_centro">
        <tr>
          <td>Copias de seguridad<br />
            <img src="imagenes/Leopard Icon (58).png" alt="" width="70" height="70" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
    </div></td>
    <td valign="top"><div class="borde_redondo">
      <table width="100%" border="0" class="texto_centro">
        <tr>
          <td>Informaci&oacute;n del Sistema<br />
            <img src="imagenes/Leopard Icon (105).png" width="70" height="70" /></td>
        </tr>
        <tr>
          <td><p>Fecha: <?php echo $Usuario->fecha; ?><br />
            Hora: <?php echo $Usuario->hora; ?></p></td>
        </tr>
      </table>
    </div></td>
    <td valign="top"><div class="borde_redondo">
      <table width="100%" border="0" class="texto_centro">
        <tr>
          <td>An&aacute;lisis de datos<br />
            <img src="imagenes/Leopard Icon (65).png" alt="" width="70" height="70" /></td>
        </tr>
        <tr>
          <td><a onclick="analisis_bdds();">Reporte Base de datos</a> </td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
<p>&nbsp;</p>
</form>
