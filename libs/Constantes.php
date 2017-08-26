<?php
class Constantes
{    
    const baseURL = "http://localhost/DTE";
    const DB_USERNAME = "username";
    const DB_PASSWORD = "password";
    const DB_NAME = "db_name";
    const DB_HOST = "localhost";
    const RESPUESTA_RECEPCION = 1;
    const RESULTADO_DTE = 2;
    const RECIBO_MERCADERIAS = 3;
    const DTEAceptadoOKV = 0;
    const DTEAceptadoOKT = "ACEPTADO OK";
    const DTEAceptadoconDiscrepanciaV = 1;
    const DTEAceptadoconDiscrepanciaT = "ACEPTADO CON DISCREPANCIAS";
    const DTERechazadoV = 2;
    const DTERechazadoT = "RECHAZADO";
    const SemillaCertificacion = "https://maullin.sii.cl/DTEWS/CrSeed.jws?WSDL";
    const SemillaProduccion = "https://palena.sii.cl/DTEWS/CrSeed.jws?WSDL";
    const TokenCertificacion = "https://maullin.sii.cl/DTEWS/GetTokenFromSeed.jws?WSDL";
    const TokenProduccion = "https://palena.sii.cl/DTEWS/GetTokenFromSeed.jws?WSDL";
    const UploadCertificacion = "https://maullin.sii.cl/cgi_dte/UPL/DTEUpload";
    const UploadProduccion = "https://palena.sii.cl/cgi_dte/UPL/DTEUpload";
    const WSEstadoEnvioCertificacion = "https://maullin.sii.cl/DTEWS/QueryEstUp.jws?WSDL";
    const WSEstadoEnvioProduccion = "https://palena.sii.cl/DTEWS/QueryEstUp.jws?WSDL";
    const WSEstadoDTECertificacion = "https://maullin.sii.cl/DTEWS/QueryEstDte.jws?WSDL";
    const WSEstadoDTEProduccion = "https://palena.sii.cl/DTEWS/QueryEstDte.jws?WSDL";
    const WSSRCorreoValidacionCertificacion = "https://maullin.sii.cl/DTEWS/services/wsDTECorreo?wsdl";
    const WSSRCorreoValidacionProduccion = "https://palena.sii.cl/DTEWS/services/wsDTECorreo?wsdl";
    const WSRegistroReclamoCertificacion = "https://ws2.sii.cl/WSREGISTRORECLAMODTECERT/registroreclamodteservice?wsdl";
    const WSRegistroReclamoProduccion = "https://ws1.sii.cl/WSREGISTRORECLAMODTE/registroreclamodteservice?wsdl";
    const PlazoDiasRespuestaSII = 8;
    
}