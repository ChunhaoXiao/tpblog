<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Admin extends Migrator
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
    public function change()
    {
        $table = $this->table('admin');
        $table->addColumn('name', 'string')
        ->addColumn('password', 'string')
        ->addColumn('login_count', 'integer', ['default' => 0])
        ->addColumn('last_login_ip', 'string', ['null' => true])
        ->addColumn('created_at', 'datetime')
        ->addColumn('updated_at', 'datetime')->create();
    }
}
