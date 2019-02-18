<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Articles extends Migrator
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
        $table = $this->table('articles');
        $table->addColumn('title', 'string', ['limit' => 50])
        ->addColumn('content', 'text')
        ->addColumn('category_id', 'integer')
        ->addColumn('created_at', 'datetime')
        ->addColumn('view_times', 'integer', ['default' => 0])
        ->addColumn('is_top', 'integer', ['default' => 0])
        ->addColumn('is_show', 'boolean', ['default' => 1])
        ->addColumn('admin_id', 'integer', ['default' => null])
        ->addColumn('updated_at', 'datetime')->create();
    }
}
