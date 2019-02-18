<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Advertisement extends Migrator
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
        $table = $this->table('advertisements');
        $table->addColumn('name', 'string')
        ->addColumn('position', 'string', ['comment' => '广告位置'])
        ->addColumn('link', 'string', ['default' => ''])
        ->addColumn('picture', 'string', ['comment' => '广告图片'])
        ->addColumn('expire_date', 'datetime', ['comment' => '广告到期时间', 'null' => true])
        ->addColumn('created_at', 'datetime')
        ->addColumn('updated_at', 'datetime')
        ->addColumn('disabled', 'boolean', ['default' => 0])->create();
    }
}
