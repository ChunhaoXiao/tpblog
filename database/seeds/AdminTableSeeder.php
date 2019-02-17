<?php

use think\migration\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            'name' => 'admin',
            'password' => md5('admin'),

        ];

        \app\common\model\Admin::create($data);
        //$table = $this->table('admin');
       /// $table->insert($data)->save();
    }
}