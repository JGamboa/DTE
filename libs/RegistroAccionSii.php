<?php

/**
 * This is the model class for table "registro_accion_sii".
 *
 * The followings are the available columns in table 'registro_accion_sii':
 * @property string $idregistro_accion_sii
 * @property string $rutEmisor
 * @property integer $tipoDoc
 * @property string $folio
 * @property string $accionDoc
 * @property integer $codResp
 * @property string $descResp
 * @property integer $pendiente
 * @property string $fechaEvento
 */
class RegistroAccionSii extends dbObject
{

    protected $dbTable = "registro_accion_sii";
    protected $primaryKey = "idregistro_accion_sii";	

	protected $dbFields = Array(
		'rutEmisor' => Array('text', 'required'),
		'tipoDoc' => Array('int'),
		'folio' => Array('int'),
		'accionDoc' => Array('text'),
		'codResp' => Array('text'),
		'descResp' => Array('text'),
		'fechaeVENTO' => Array('dateTime'),
	);		


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idregistro_accion_sii' => 'Idregistro Accion Sii',
			'rutEmisor' => 'Rut Emisor',
			'tipoDoc' => 'Tipo Doc',
			'folio' => 'Folio',
			'accionDoc' => 'Accion Doc',
			'codResp' => 'Cod Resp',
			'descResp' => 'Desc Resp',
			'pendiente' => 'Pendiente',
		);
	}

        
    public function getAccionDesc(){
        return $this->accionDoc . " - " . $this->descResp;
    }

        
}
