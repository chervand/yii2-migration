<?php

namespace chervand\migration;

/**
 * Class Migration
 * @package console\components
 * @property array $metaColumns
 * @property array $tableOptions
 */
class Migration extends \yii\db\Migration
{
    public function createTable($table, $columns, $addMetaColumns = true)
    {
        if ($addMetaColumns === true) {
            $columns = array_merge($columns, $this->metaColumns);
        }

        parent::createTable($table, $columns, $this->tableOptions);
    }

    protected function getMetaColumns()
    {
        return [
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'KEY (`status`)',
        ];
    }

    protected function getTableOptions()
    {
        switch ($this->db->driverName) {
            case 'mysql':
                return 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                break;
            default:
                return null;
        }
    }
}
