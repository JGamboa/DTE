<?php

require_once ("tcpdf_barcodes_2d.php");

$code = $_POST['ted'];
//$code = utf8_encode($code);
//$code = "<TED version=\"1.0\"><DD><RE>97975000-5</RE><TD>33</TD><F>60</F><FE>2003-10-13</FE><RR>77777777-7</RR><RSR>EMPRESA  LTDA</RSR><MNT>119000</MNT><IT1>Parlantes Multimedia 180W.</IT1><CAF version=\"1.0\"><DA><RE>97975000-5</RE><RS>RUT DE PRUEBA</RS><TD>33</TD><RNG><D>1</D><H>200</H></RNG><FA>2003-09-04</FA><RSAPK><M>0a4O6Kbx8Qj3K4iWSP4w7KneZYeJ+g/prihYtIEolKt3cykSxl1zO8vSXu397QhTmsX7SBEudTUx++2zDXBhZw==</M><E>Aw==</E></RSAPK><IDK>100</IDK></DA><FRMA algoritmo=\"SHA1withRSA\">g1AQX0sy8NJugX52k2hTJEZAE9Cuul6pqYBdFxj1N17umW7zG/hAavCALKByHzdYAfZ3LhGTXCai5zNxOo4lDQ==</FRMA></CAF><TSTED>2003-10-13T09:33:20</TSTED></DD><FRMT algoritmo=\"SHA1withRSA\">GbmDcS9e/jVC2LsLIe1iRV12Bf6lxsILtbQiCkh6mbjckFCJ7fj/kakFTS06Jo8iS4HXvJj3oYZuey53Krniew==</FRMT></TED>";
$type = "PDF417,1,5";

$barcodeobj = new TCPDF2DBarcode($code, $type);

$barcodeobj->getBarcodePNG(1.0,0.6);

?>