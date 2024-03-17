<?php include("includes/acceso.php"); ?>
<?php
require_once 'componentes/kendo/DataSourceResult.php';
require_once 'componentes/kendo/Autoload.php';

?>
<link rel="stylesheet" type="text/css" href="componentes/kendo/styles/kendo.common.min.css" />
<link rel="stylesheet" type="text/css" href="componentes/kendo/styles/kendo.default-v2.min.css" />
<link rel="stylesheet" type="text/css" href="componentes/kendo/styles/kendo.bootstrap.min.css" />

<!--<script src="componentes/kendo/js/jquery.min.js"></script>-->
<script src="componentes/kendo/js/kendo.all.min.js"></script>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    $request = json_decode(file_get_contents('php://input'));

    $result = new DataSourceResult("'mysql:host=" . CONFIG_HOST . ";dbname=" . CONFIG_BASE_DATOS ."'", CONFIG_USUARIO, CONFIG_CLAVE_BASE);
    //$result = new DataSourceResult('sqlite:..//sample.db');
    //"mysql:host=$host;dbname=$dbname", $username, $password)
    echo json_encode($result->read('acta_elemento', array('id_ae', 'nombre_elemento', 'contiene'), $request));

    exit;
}

$transport = new \Kendo\Data\DataSourceTransport();

$read = new \Kendo\Data\DataSourceTransportRead();

//$read->url('bloques/revision/rev_correcion.php')
$read->url('rev_correcion.php')
    ->contentType('application/json')
    ->type('POST');

$transport ->read($read)
    ->parameterMap('function(data) {
              return kendo.stringify(data);
          }');

$model = new \Kendo\Data\DataSourceSchemaModel();

$contactNameField = new \Kendo\Data\DataSourceSchemaModelField('nombre_elemento');
$contactNameField->type('string');

$contactTitleField = new \Kendo\Data\DataSourceSchemaModelField('contiene');
$contactTitleField->type('string');


$model->addField($contactNameField)
    ->addField($contactTitleField);

$schema = new \Kendo\Data\DataSourceSchema();
$schema->data('data')
    ->errors('errors')
    ->groups('groups')
    ->model($model)
    ->total('total');

$dataSource = new \Kendo\Data\DataSource();

$dataSource->transport($transport)
    ->pageSize(10)
    ->serverPaging(true)
    ->serverSorting(true)
    ->serverGrouping(true)
    ->schema($schema);

$grid = new \Kendo\UI\Grid('grid');

/*
$contactName = new \Kendo\UI\GridColumn();
$contactName->field('ContactName')
    ->template("<div class='customer-photo'style='background-image: url(../content/web/Customers/#:data.CustomerID#.jpg);'></div><div class='customer-name'>#: ContactName #</div>")
    ->title('Contact Name')
    ->width(240);

$contactTitle = new \Kendo\UI\GridColumn();
$contactTitle->field('ContactTitle')
    ->title('Contact Title');

$companyName = new \Kendo\UI\GridColumn();
$companyName->field('CompanyName')
    ->title('Company Name');

$Country = new \Kendo\UI\GridColumn();
$Country->field('Country')
    ->width(150);
*/

$titNombreElemento = new \Kendo\UI\GridColumn();
$titNombreElemento->field('nombre_elemento')
    ->title('Elemento');

$titContiene = new \Kendo\UI\GridColumn();
$titContiene->field('contiene')
    ->title('Company Name');

$pageable = new Kendo\UI\GridPageable();
$pageable->refresh(true)
    ->pageSizes(true)
    ->buttonCount(5);

$grid->addColumn($titNombreElemento, $titContiene)
    ->dataSource($dataSource)
    ->sortable(true)
    ->groupable(true)
    ->pageable($pageable)
    ->attr('style', 'height:550px');

echo $grid->render();
?>

<style type="text/css">
    .customer-photo {
        display: inline-block;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-size: 32px 35px;
        background-position: center center;
        vertical-align: middle;
        line-height: 32px;
        box-shadow: inset 0 0 1px #999, inset 0 0 10px rgba(0,0,0,.2);
        margin-left: 5px;
    }

    .customer-name {
        display: inline-block;
        vertical-align: middle;
        line-height: 32px;
        padding-left: 3px;
    }
</style>
