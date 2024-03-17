<?php include("includes/acceso.php"); ?>
<?php
// Acceso a Datos
include_once 'datos/d_clientes.php';

$Cliente = new d_clientes();


// Calculos y procesos

// Eventos Ajenos

// Eventos Propios
$Cliente->listar_cliente();
?>
<style>
    details {
        display:block;
        width:100%;
        margin:10px 0;
    }
    summary {
        display:block;
        background:#99B92C;
        color:white;
        border-radius:5px;
        padding:5px;
        cursor:pointer;font-weight:bold;
    }

    summary::-webkit-details-marker {
        color:#FF0000;
        background:#FFFFFF;
    }

    details[open] summary::-webkit-details-marker {
        color:#0000FF;
        background:#00FFFF;
    }
    summary::-webkit-details-marker {
        display: none
    }

    summary:after {
        content: "+";
        color: #FFFFFF;
        float: left;
        font-size: 1.5em;
        font-weight: bold;
        margin: -5px 5px 0 0;
        padding: 0;
        text-align: center;
        width: 20px;
    }

    details[open] summary:after {
        content: "-";
        color: #FFFFFF
    }
</style>
<button type="button" class="btn btn-primary btn-rounded btn-icon">
    <i class="fas fa-cogs"> Procesar Automáticamente</i>
</button>
<button type="button" class="btn btn-dark btn-rounded btn-icon">
    <i class="fas fa-binoculars"> Mostrar Detalles</i>
</button>
<button type="button" class="btn btn-info btn-rounded btn-icon">
    <i class="far fa-bell-slash"> Ocultar</i>
</button>

<div class="padding">
    <form name="form1" method="post" action="">
    <div class="row container d-flex justify-content-center">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Revision de Actas Subidas</h4>
                    <p class="card-description">Controle y revise las actas</p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Evento</th>
                                <th>Estado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php for($i = 0; $i < $Cliente->num_filas; $i++){
                                $badgeMensaje = "";
                                $badgeClase = "";
                                switch ($Cliente->datos[$i]->estado){
                                    case -1:
                                        $badgeMensaje = "Eliminado";
                                        $badgeClase = "badge badge-danger";
                                        break;
                                    case 0:
                                        $badgeMensaje = "Solo procesado basico";
                                        $badgeClase = "badge badge-danger";
                                        break;
                                    case 1:
                                        $badgeMensaje = "Procesado automático";
                                        $badgeClase = "badge badge-info";
                                        break;
                                    case 2:
                                        $badgeMensaje = "Pendiente de revision";
                                        $badgeClase = "badge badge-info";
                                        break;
                                    case 3:
                                        $badgeMensaje = "Revisado y Terminado";
                                        $badgeClase = "badge badge-success";
                                        break;
                                }
                                $estado = "<div id='div_badge_" . $Cliente->datos[$i]->id_cliente . "'>";
                                $estado = $estado . "<div id='div_badge_a_" . $Cliente->datos[$i]->id_cliente . "' class='badge " . $badgeClase . "'>" . $badgeMensaje . "</div>";
                                $estado = $estado . "</div>";
                                ?>
                            <tr>
                                <td><?php echo $i +1; ?></td>
                                <td><?php echo $Cliente->datos[$i]->id; ?></td>
                                <td><?php echo $Cliente->datos[$i]->fecha; ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-rounded btn-icon" onclick="procesar(<?php echo $Cliente->datos[$i]->id_cliente; ?>)">
                                        <i class="fas fa-cogs"></i>
                                    </button>
                                    <button type="button" class="btn btn-dark btn-rounded btn-icon" onclick="administrar(<?php echo $Cliente->datos[$i]->id_cliente; ?>)">
                                        <i class="fas fa-binoculars"></i>
                                    </button>
                                    <button type="button" class="btn btn-info btn-rounded btn-icon" onclick="ocultar(<?php echo $Cliente->datos[$i]->id_cliente; ?>)">
                                        <i class="far fa-bell-slash"></i>
                                    </button>

                                </td>
                                <td><?php echo $estado; ?></td>
                            </tr>
                                <tr>
                                    <td colspan="5">
                                        <div id="class-<?php echo $Cliente->datos[$i]->id_cliente; ?>">

                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<script language="javascript">
    function recibir(id_control)
    {
        var valor_input = document.getElementById("it_" + id_control).value;
        actualiza_ce(id_control,valor_input);

    }
</script>