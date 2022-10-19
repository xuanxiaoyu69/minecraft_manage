<?php
use think\migration\Migrator;

class MigrationCmfCreateServerTable extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
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
        $table = $this->table('server');
        $table->addColumn('name', 'string', ['comment' => '服务器名称'])
              ->addColumn('host', 'string', ['comment' => '服务器ip'])
              ->addColumn('user', 'string', ['comment' => '服务器账号'])
              ->addColumn('pass', 'string', ['comment' => '服务器密码', 'default' => null, 'null' => true])
              ->addColumn('port', 'integer', ['comment' => '服务器端口'])
              ->addColumn('key', 'string', ['comment' => '服务器证书', 'default' => null, 'null' => true])
              ->addColumn('addtime', 'integer', ['comment' => '添加时间', 'default' => null, 'null' => true])
              ->addColumn('updatetime', 'integer', ['comment' => '更新时间', 'default' => null, 'null' => true])
              ->addColumn('deletetime', 'integer', ['comment' => '删除时间', 'default' => 0])
              ->create();
    }
}
