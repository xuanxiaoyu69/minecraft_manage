<?php
use think\migration\Migrator;

class MigrationCmfCreateVersionTable extends Migrator
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
        $table = $this->table('version', ['signed' => false]);
        $table->addColumn('name', 'string', ['comment' => '版本号'])
            ->addColumn('release_time', 'integer', ['comment' => '发布时间'])
            ->addColumn('download_url', 'string', ['comment' => '下载链接'])
            ->addColumn('group', 'string', ['comment' => '版本分组'])
            ->addColumn('addtime', 'integer', ['comment' => '添加时间', 'default' => null, 'null' => true])
            ->addColumn('updatetime', 'integer', ['comment' => '更新时间', 'default' => null, 'null' => true])
            ->addColumn('deletetime', 'integer', ['comment' => '删除时间', 'default' => 0])
            ->create();
    }
}
