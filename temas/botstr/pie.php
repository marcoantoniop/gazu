<footer>
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
</footer>

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