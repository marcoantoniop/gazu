<?php
// Acceso a Datos
include_once "componentes/extractorpdf/ClassExtractor.php";

$claseExtractor = new ClassExtractor();
$claseExtractor->carpeta = "adjuntos";
$claseExtractor->listar_carpetas();
$claseExtractor->crearXmlCarpetas();
$claseExtractor->crearXmlArchivos();
// Calculos y procesos

// Eventos Ajenos

// Eventos Propios

?>
<div id="layoutObj" align="right" style="border-left: 30em; width: 100%; height: 100%;"></div>
<div id="logBar"></div>
<div id="div_pdfprocesado"></div>

<script type="text/javascript">
    var myToolbar;
    var myLayout;
    var myTree;
    var myGrid;
    var i = 1;
    dhtmlxEvent(window,"load",function(){
        myLayout = new dhtmlXLayoutObject("layoutObj","2U");
        myLayout.cells("a").setWidth(250);
        myLayout.cells("a").setText("Carpetas");
        myLayout.cells("b").hideHeader();

        myToolbar = myLayout.attachToolbar();
        myToolbar.setIconsPath("icons/");
        myToolbar.loadStruct("bloques/extractor/botones.xml");
        myToolbar.attachEvent("onClick", function(id) {
            switch (id) {
                case "import":
                    importarSeleccion();
                    break;
                case "all":
                    seleccionTodos();
                    break;
                case "none":
                    seleccionNinguno();
                    break;
            }
            //writeLog("<b>onClick event</b> button("+id+") was clicked");
        });

        myTree = myLayout.cells("a").attachTree();
        myTree.setImagesPath("componentes/dhtmlx/imgs/dhxtree_material/");
        //myTree.load("bloques/extractor/archivos.xml");



        myGrid = myLayout.cells("b").attachGrid();
        myGrid.setImagePath("componentes/dhtmlx/imgs/dhxgrid_material/");    //sets the path to the source images
        myGrid.setIconsPath("icons/");                //sets the path to custom images
        myGrid.setHeader("&nbsp;,Sel,Archivo,Tipo,Carpeta,id");     //sets the header labels
        myGrid.setColTypes("img,ch,ro,ro,ro,ro");             //sets the types of columns
        myGrid.setInitWidths("70,80,250,100,*,0");   //sets the initial widths of columns
        myGrid.setColAlign("center,center,left,left,left");   //sets the horizontal alignment
        myGrid.init();
        //myGrid.load("bloques/extractor/archivos_grid.xml");



        myTree.load("bloques/extractor/carpetas.xml",function() {
            myGrid.load("bloques/extractor/archivos.xml", function () {
                    myTree.selectItem("books");
                }
            );
        });
        myTree.attachEvent("onSelect",  function(id){
            //id -the id of the selected item
            myGrid.filterBy(5,id);
            return true;
        });
    });

    function writeLog(data) {
        document.getElementById("logBar").innerHTML = String(i++)+". "+data+"<br>"+document.getElementById("logBar").innerHTML;
        document.getElementById("logBar").innerHTML+="";
        //alert(data);
mygrid.forEachRow(function(id) {
    mygrid.CellById(row_id,0).setValue(id); //id - the row id
});
    }
    
    function importarSeleccion() {
        //alert("okk");
        myGrid.forEachRow(function(id) {
            if(myGrid.cellById(id,1).getValue() == 1){
                fila(myGrid.cellById(id,2).getValue(),myGrid.cellById(id,4).getValue());
            }

        });
        //for (var i=0; i<myGrid.count(); i++){
        //    alert(myGrid.cells(row_id,col_ind).getValue()); //i-index of a column (zero-based numbering)
        //}
    }

    function fila(archivo,carpeta){
        //alert(id.toString());
        extraer_archivo_pdf(archivo, carpeta);
        //var parametros = "archivo=" + archivo + "&carpeta=" + carpeta;
        //dhtmlxAjax.get("componentes/extractorpdf/extraer_archivo_pdf.php?" + encodeURI(parametros));
        //document.getElementById("logBar").innerHTML = String(i++)+". "+archivo+"<br>"+document.getElementById
        //("logBar")
        //    .innerHTML;
        //document.getElementById("logBar").innerHTML+="";
    }

    function seleccionNinguno(){
        myGrid.forEachRow(function(id) {
            myGrid.cellById(id,1).setValue(0);
        });
    }
    function seleccionTodos(){
        myGrid.forEachRow(function(id) {
            myGrid.cellById(id,1).setValue(1);
        });
    }
    function outputResponse(loader) {
        /*
        if (loader.xmlDoc.responseXML != null) {
            alert("We Got Response\n\n" + loader.doSerialization());
        } else {
            alert("Response contains no XML");
        }
        */
    }


</script>