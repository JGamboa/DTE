<?php

//echo $_POST['css'];
echo "<!DOCTYPE html>\n<html>\n<head>\n <meta charset='utf8'>\n".$_POST['css']."</head><body onload='
var count = document.getElementsByClassName(\"hojaCarta\").length;
var divPC = document.getElementById(\"pageCount\");
var div = document.getElementById(\"hoja1\");
var divH = document.getElementById(\"valorhoja\");
divH.value = (div.offsetHeight * 0.02645833333333);
divPC.value = count'>";
echo "<form action='#' method='GET'>
      <input type='hidden' name='ticket' value='true' />
      <input type='hidden' name='empresa' value='". $_POST['empresa'] ."' />
      <input type='hidden' name='unidad_regional' value='". $_POST['unidad_regional'] ."' />
      <input type='hidden' name='numero_resolucion' value='". $_POST['numero_resolucion'] ."' />
      <input type='hidden' name='fecha_resolucion' value='". $_POST['fecha_resolucion'] ."' />    
      <input type='hidden' name='archivo' value='". $_POST['archivo'] ."' />
      <input type='hidden' name='pageCount' id='pageCount' /> 
      <input type='hidden' value='". $_POST['id']."' name='id'>
      <input type='hidden' name='altura' id='valorhoja'/><button type='submit'>Ver PDF</button></form>";
echo $_POST['html'];
echo "</body></html>";

?>