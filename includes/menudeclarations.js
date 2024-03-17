var timeOut = null, numMenus = 0;
var menus = new Object();
var activeMenuHeading = -1;
function showMenu(which, x, y){
	document.getElementById("menu" + which).style.left = x;
	document.getElementById("menu" + which).style.top = y;
	document.getElementById("menu" + which).style.visibility = "visible";
}
function hideMenu(which){
	document.getElementById("menu" + which).style.visibility = "hidden";
}
function addItem(menuName, item, action){
	if (!menus[menuName]){
		var newMenu = new Object();
		newMenu.name = menuName;
		newMenu.num = numMenus++;
		newMenu.items = new Array();
		newMenu.actions = new Array();
		menus[menuName] = newMenu;
	}
	menus[menuName].items[menus[menuName].items.length] = item;
	menus[menuName].actions[menus[menuName].actions.length] = action;
}
function createMenuHeadings(){
	//document.write('<div class="menuBar">');
	for (var menu in menus){
		var theMenu = menus[menu];
		document.write('<a class="menuHeading" onclick="menuHeadingMouseClick(event, '+
		theMenu.num + '); return false;" onmouseout="menuHeadingMouseOut('+
		//theMenu.num + ')" onmouseover="menuHeadingMouseOver('+
		theMenu.num + ')" onmouseover="menuHeadingMouseClick(event, '+
		theMenu.num + ')" name="menuHeading" id="menuHeading'+
		theMenu.num + '">' + theMenu.name + '</a>');//The last <br> changes the orientation of the menu, instead of <br> now I'm using css styles (display: block).
	}
	/*document.write('</div>');*/
}
function createMenus(){
	createMenuHeadings();
	for(var menu in menus){
		var theMenu = menus[menu];
		document.write('<div class="menu" id="menu' + theMenu.num +
		'" onmouseover="clearTimeout(timeOut);" onmouseout="timeOut = '+
		'setTimeout(\'menuHeadingDeactivate(); hideMenu(' + theMenu.num + ');\', 100)">');
		//'setTimeout(\'menuHeadingDeactivate(); hideMenu(' + theMenu.num + ');\', 500)">');
		for (var i=0; i<theMenu.items.length; i++){
			document.write('<a style="width:100px" class="menuItem" href="' + theMenu.actions[i] + '">' +
			theMenu.items[i] + '</a>');//Carefully with the last <br>
		}
		document.write('</div>');
	}
}
function menuHeadingMouseOver(menuHeading){
	document.getElementById("menuHeading"+menuHeading).style.borderColor = "lightblue darkblue darkblue lightblue";
}
function menuHeadingMouseOut(menuHeading){
	if (activeMenuHeading != -1 && activeMenuHeading == menuHeading)
		timeOut = setTimeout('hideMenu('+ activateMenuHeading +'); menuHeadingDeactivate();',100);
	else
		document.getElementById("menuHeading"+menuHeading).style.borderColor = "blue";
}
function menuHeadingActivate(menuHeading){
	//color: #224a8a;
	//background-color: #7da1e4;
	document.getElementById("menuHeading"+menuHeading).style.background = "#7da1e4";//"lightblue";
	document.getElementById("menuHeading"+menuHeading).style.color = "#224a8a";//"darkblue";
	//document.getElementById("menuHeading"+menuHeading).style.borderColor = "darkblue blue lightblue darkblue";
	activateMenuHeading = menuHeading;
}
function menuHeadingDeactivate(){
	if (activeMenuHeading != -1){
		//document.getElementById("menuHeading"+activeMenuHeading).style.borderColor = "blue";
		document.getElementById("menuHeading"+activeMenuHeading).style.background = "white";
		document.getElementById("menuHeading"+activeMenuHeading).style.color = "#184870";
	}
	activeMenuHeading = -1;
}		 
function menuHeadingMouseClick(event, which){
	if (activeMenuHeading != -1){
		clearTimeout(timeOut);
		hideMenu(activeMenuHeading);
		menuHeadingDeactivate();
	}
	menuHeadingActivate(which);
	activeMenuHeading = which;
	/*
	if (event.srcElement){
		x = event.srcElement.offsetLeft;
		y = event.srcElement.offsetTop + event.srcElement.offsetHeight;
	}
	else{
		x = document.getElementById("menuHeading"+which).offsetLeft;
		y = document.getElementById("menuHeading"+which).offsetTop + document.getElementById("menuHeading"+which).offsetHeight;
	}
	*/
	x = 160;//document.getElementById("menuHeading"+which).offsetWidth;
	y = document.getElementById("menuHeading"+which).offsetTop;
	//The two above lines are to show the menu next to the header.
	showMenu(which, x, y);
}