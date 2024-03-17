////////////////////////////////////////////////////////////////////////////////////////////////
//  Biblioteca de utilidades para manejo de la API de Pantalla Completa de HTML5
//  Permite manejarla de manera independiente del navegador, simplificando su uso.
//
//  Creada por Jos� Manuel Alarc�n, Mayo de 2014.
//  Puedes usarla y adaptarla libremente pero debes mantener esta nota informativa con mi nombre
//  y un enlace a mi blog en www.jasoft.org
///////////////////////////////////////////////////////////////////////////////////////////////

// Funci�n para comprobar si el navegador actual soporta o no la API de pantalla comleta. 
// Comprueba con todos los prefijos espec�ficos del navegador por si acaso.
function FullScreenSupportEnabled() {
	return (document.fullscreenEnabled || 
			document.webkitFullscreenEnabled || 
			document.mozFullScreenEnabled ||
			document.msFullscreenEnabled);
}

//Devuelve true si hay alg�n elemento en modo pantalla completa o false si no lo hay (o no se soporta, que para el caso es lo mismo)
function CurrentlyInFullScreen() {
    return (document.fullscreenElement ||
    document.webkitFullscreenElement ||
    document.mozFullScreenElement ||
    document.msFullscreenElement);
}

//Funci�n que, al pasarle un elemento, intenta ponerlo en modo pantalla completa, probando para ello
//las diversas variantes de la API FullScreen seg�n el navegador.
//Devuelve false si algo falla o true si ha funcionado la llamada a la API
function SetFullScreen(elto) {
	//Si no se soporta la API, ya ni lo intentamos
	if (!FullScreenSupportEnabled()) return;
	//Se prueba la variante apropiada seg�n el navegador
	try {
		if (elto.requestFullscreen) {	//Empezando por la est�ndar
			elto.requestFullscreen();
		} else if (elto.webkitRequestFullscreen) {	//Webkit (Safari, Chrome y Opera 15+)
			elto.webkitRequestFullscreen();
		} else if (elto.mozRequestFullScreen) {	//Firefox
			elto.mozRequestFullScreen();
		} else if (elto.msRequestFullscreen) {	//Internet Explorer 11+
			elto.msRequestFullscreen();
		}
	}
	catch(ex) {
		return false;
	}
	return true;
}

//Devuelve una referencia al elemento que est� actualmente en modo pantalla completa
//o un null en caso de que no haya ninguno
function getCurrentElementInFullScreen(){
	if (document.fullscreenElement)
		return document.fullscreenElement;
	if (document.webkitFullscreenElement)
		return document.webkitFullscreenElement;
	if (document.mozFullScreenElement)
		return document.mozFullScreenElement;
	if (document.msFullscreenElement)
		return document.msFullscreenElement;

	return null;
}

//Sale del modo pantalla completa si es que estaba previamente en �ste
function ExitFullScreenMode(){
	if (document.exitFullscreen) {
		document.exitFullscreen();
	} else if (document.webkitExitFullscreen) {
		document.webkitExitFullscreen();
	} else if (document.mozCancelFullScreen) {
		document.mozCancelFullScreen();
	} else if (document.msExitFullscreen) {
		document.msExitFullscreen();
	}
}

//A�ade el manejador especificado como par�metro al evento de detecci�n de cambio de estado de pantalla completa
//Se puede comprobar si est� actualmente en un modo u otro con la funci�n CurrentlyInFullScreen
function AddFullScreenChangeEventHandler(handler){
	document.addEventListener("fullscreenchange", handler);
	document.addEventListener("webkitfullscreenchange", handler);
	document.addEventListener("mozfullscreenchange", handler);
	document.addEventListener("MSFullscreenChange", handler);
}

//A�ade un manejador para cuando se produce un error al cambiar el modo de pantalla completa
//por ejemplo, al intentar hacerlo con un elemento que no lo permite
function AddFullScreenErrorEventHandler(handler){
	document.addEventListener("fullscreenerror", handler);
	document.addEventListener("webkitfullscreenerror", handler);
	document.addEventListener("mozfullscreenerror", handler);
	document.addEventListener("MSFullscreenError", handler);
}