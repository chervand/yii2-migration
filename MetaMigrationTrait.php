<?php

namespace chervand\migration;

/**
 * Class MetaMigrationTrait
 * @package chervand\migration
 *
 * @property array $metaColumns
 * @property null|string $tableOptions
 */
trait MetaMigrationTrait
{
    /**
     * @param string $table
     * @param array $columns
     * @param null|string $options
     */
    public function createMetaTable($table, $columns, $options = null)
    {
        $columns = array_merge($columns, $this->metaColumns);

        /** @var \yii\db\Migration $this */
        $this->createTable($table, $columns, $options);
    }

    /**
     * @param string $table
     * @param array $columns
     */
    public function insertIntoMetaTable($table, $columns)
    {
        $columns = array_merge($columns, ['created_at' => time(), 'updated_at' => time()]);

        /** @var \yii\db\Migration $this */
        $this->insert($table, $columns);
    }

    /**
     * @return array
     */
    public function getMetaColumns()
    {
        /** @var \yii\db\Migration $this */
        return [
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'KEY (`status`)',
        ];
    }

    /**
     * @return null|string
     */
    public function getTableOptions()
    {
        /** @var \yii\db\Migration $this */
        switch ($this->db->driverName) {
            case 'mysql':
                return 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                break;
            default:
                return null;
        }
    }
}
