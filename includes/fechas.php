<?php
/********************************************************************
*	Date - form field function.
*	Its return a drop-down-menu form-field
*   Syntax :
*		- string listbox_date(string name, int selected-date);
*		- string listbox_month(string name, int selected-month);
*		- string listbox_year(string name, int start-year, int end-year, int selected-year);
*
*	Copyright (C) 2001 Wibisono Sastrodiwiryo. 
*   	This program is free software licensed under the 
*   	GNU General Public License (GPL).
*
*   CyberGL => Application Service Provider
*   http://www.cybergl.co.id
*	office@cybergl.co.id
*
*   $Id: date.php3,v 0.1 2001/04/24 21:6:31 wibi Exp $ 
*********************************************************************/

function listbox_date ($name, $default=0) {
	$result="<select name=\"$name\" size=1>\n";
	for ($d=1;$d<=31;$d++) {
		if ($default  == $d) {$selected="selected";} else {$selected="";}
		$result.="<option value=\"$d\" $selected>$d</option>\n";
	}
	$result.="</select>\n";
return $result;
}

function listbox_month ($name, $default=0) {
	$result="<select name=\"$name\" size=1>\n";
	for ($m=1;$m<=12;$m++) {
		if ($default  == $m) {$selected="selected";} else {$selected="";}
		$result.="<option value=\"$m\" $selected>".date('m', mktime(0,0,0,$m,1,2000))."</option>\n";
	}
	$result.="</select>\n";
return $result;
}

function listbox_year ($name, $start, $end, $default=0) {
	$result="<select name=\"$name\" size=1>\n";
	for ($y=$end;$y>=$start;$y--) {
		if ($default  == $y) {$selected="selected";} else {$selected="";}
		$result.="<option value=\"$y\" $selected>$y</option>\n";
	}
	$result.="</select>\n";
return $result;
}

function listbox_hora($nombre){
	$result="<select name=\"$nombre\" size=1>\n";
	for ($i=0 ;$i < 24;$i++) {
		$result.="<option value=\"$i\">$i</option>\n";
	}
	$result.="</select>\n";
return $result;
}

function listbox_minuto($nombre){
	$result="<select name=\"$nombre\" size=1>\n";
	for ($i=0 ;$i < 60;$i++) {
		$result.="<option value=\"$i\">$i</option>\n";
	}
	$result.="</select>\n";
return $result;	
}
?>
	