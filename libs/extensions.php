<?php

function ConexionAutomaticaSII($empresa = "", &$mensaje = "", $cron = ""){
    /*@var $empresa Emisores */
        try{

            $cliente = new nusoap_client(Constantes::SemillaProduccion, false);
            $result = $cliente->call('getSeed');
            
            if ($cliente->fault) {
                $mensaje .= "<h2>Fault</h2><pre>";
                $mensaje .= $result;
                $mensaje .="</pre>";
                return false;
            }
            
            $soapError = $cliente->getError();
            if (!empty($soapError)) {
                $mensaje .= 'SOAP method invocation (verifyT) failed: ' . $soapError;
                return false;            
            }              
            
            $pRutEmpresa   = substr($empresa,0, -2);
            
            $seed = new DOMDocument;
            $seed->loadXML($result);
            $semilla = $seed->getElementsByTagName("SEMILLA")->item(0)->nodeValue;
            $estado = $seed->getElementsByTagName("ESTADO")->item(0)->nodeValue;
            
            if($estado == "00"){
                $xmlr = simplexml_load_string($result);
                $nombre_semilla = md5(uniqid());
                $xmlr->saveXML("semillas/" . $nombre_semilla .".xml");             
                $body = "<getToken><item><Semilla>$semilla</Semilla></item></getToken>";
                $dom = new DOMDocument;
                $dom->formatOutput = FALSE;
                $dom->preserveWhiteSpace = TRUE;

                $dom->loadXML($body);

                //se debe agregar libreria xmlseclibs
		        $xmlTool = new FR3D\XmlDSig\Adapter\XmlseclibsAdapter();
		        $key = array();
                $pfx_archivo = "certif/".$empresa.".pfx";
		        $pfx = file_get_contents("certif/".$empresa.".pfx");


                if(file_exists($pfx_archivo)){
			        $clave = file_get_contents("certif/".$empresa.".txt");
			        openssl_pkcs12_read($pfx, $key, $clave);
			        $xmlTool->setPrivateKey($key["pkey"]);
			        $xmlTool->setpublickey($key["cert"]);
			        $xmlTool->addTransform(FR3D\XmlDSig\Adapter\XmlseclibsAdapter::ENVELOPED);
			        $xmlTool->sign($dom);
			        $nombre_token = md5(uniqid());
			        $dom->save("semillas/". $nombre_token .".xml");


		            $TokenClient = new nusoap_client(Constantes::TokenProduccion, false);
		            $rs = $TokenClient->call('getToken', array($dom->saveXML()));

                    if ($TokenClient->fault) {
                        $mensaje .= "<h2>Fault</h2><pre>";
                        $mensaje .= $result;
                        $mensaje .="</pre>";
	                    return false;            
                    }

                    $soapError = $TokenClient->getError();
                    if (!empty($soapError)) {
                        $mensaje .= 'SOAP method invocation (verifyT) failed: ' . $soapError;
                        return false;             
                    }            

		            /***** OBTENER EL TOKEN *****/
		            $formato = str_replace( 'SII:', '', $rs );
		            $xml = simplexml_load_string($formato);
		            $tokenSII = $xml->RESP_BODY->TOKEN;
		            /***** OBTENER EL TOKEN *****/  
		            
		            unlink("semillas/". $nombre_token .".xml");     
		            unlink("semillas/". $nombre_semilla .".xml");  

                    if($tokenSII == NULL || $tokenSII == ""){
                        return FALSE;
                    }   
                    
                    return $tokenSII;
                }else{
                    echo "NO SE ENCONTRO EL CERTIFICADO \n\r";
                    return "1";
                }
            }else{
                $mensaje = "Error con conexion SII, Error numero : " . $estado;
                return false;
            }
        }catch(SoapFault $exception){
            echo "ERROR <br/>";
            echo $exception->getTraceAsString();
            echo $exception->getMessage();
            die();
        }            
}
