<?php

use Phinx\Migration\AbstractMigration;

class CreateConsultasWsSiiTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $table = $this->table('consultas_ws_sii', array('id' => false, 'primary_key'=>'idconsulta_ws_sii'));
        $table->addColumn('idconsulta_ws_sii', 'integer', array('signed' => false, 'auto_increment' => true))
            ->addColumn('rutEmisor', 'string', array('limit' => 10))
            ->addColumn('tipoDoc', 'integer', array('limit' => MysqlAdapter::INT_TINY))
            ->addColumn('folio', 'decimal', array('precision' => 10, 'scale' => 0, 'signed' => false))
            ->addColumn('fechaRecepcionSii', 'datetime', array('null' => true))
            ->addColumn('codResp_cedible', 'datetime', array('null' => true, 'limit' => MysqlAdapter::INT_TINY))
            ->addColumn('desc_cedible', 'string', array('null' => true, 'limit' =>70))
            ->save();
    }
}
