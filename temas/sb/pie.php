
<!-- Footer -->
<footer class="sticky-footer bg-white" data-pg-collapsed>
    <div class="container my-auto">
        <ol class="breadcrumb float-right" data-pg-collapsed>
            <li class="breadcrumb-item">
                <a href="?">Inicio</a>
            </li>

            <li class="breadcrumb-item">
                <a onClick="launchFullScreen(document.documentElement)">Pantalla Completa</a>
            </li>
            <li class="breadcrumb-item">
                <a onClick="cancelFullscreen()">Cerrar Pantalla Completa</a>
            </li>

            <li class="breadcrumb-item active">Data</li>
        </ol>

    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<?php
    $res = Mostrar_ClaseMenu(0,'primero');
    echo $res;
    //print_r($res);
?>
<?php
/**
 *  COMPROBAMOS SI MOSTRAMOS O NO EL MENU
 */
if(!ClassSaltar::DeboSaltaMenu()){
    //include "temas/sb/sidebar.php";
}


?>
<!-- End of Page Wrapper -->

<script>
    var fullscreenElement = document.fullScreenElement || document.mozFullScreenElement || document.webkitFullScreenElement;
    var fullscreenEnabled = document.fullScreenEnabled || document.mozScreenEnabled || document.webkitScreenEnabled;

    function cancelFullscreen() {
      if(document.cancelFullScreen) {
        document.cancelFullScreen();
      } else if(document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if(document.webkitCancelFullScreen) {
        document.webkitCancelFullScreen();
      }
    }
    //cancelFullscreen();

    // Encuentra el método correcto, llama al elemento correcto
    function launchFullScreen(element) {
      if(element.requestFullScreen) {
        element.requestFullScreen();
      } else if(element.mozRequestFullScreen) {
        element.mozRequestFullScreen();
      } else if(element.webkitRequestFullScreen) {
        element.webkitRequestFullScreen();
      }
    }
     
    // Lanza en pantalla completa en navegadores que lo soporten
    //launchFullScreen(document.documentElement); // la página entera
    //launchFullScreen(document.getElementById("videoElement")); // cualquier elemento individual



</script>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top" data-pg-collapsed>
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>



<!-- Page level plugins -->
<script src="temas/sb/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<!--<script src="temas/sb/js/demo/chart-area-demo.js"></script>-->
<!--<script src="temas/sb/js/demo/chart-pie-demo.js"></script>-->

<script type="text/javascript" src="componentes/menus/sdmenu.js"></script>

<!-- Bootstrap-Iconpicker Bundle -->
<script type="text/javascript" src="componentes/bootstrap-iconpicker/dist/js/bootstrap-iconpicker.bundle.min.js"></script>


</body>

</html>
