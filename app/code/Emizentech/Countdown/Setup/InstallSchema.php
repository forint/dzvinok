<?php
declare(strict_types=1);

namespace Emizentech\Countdown\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @package Emizentech\Countdown\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('emizentech_countdown'))
            ->addColumn('id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'ID'
            )
            ->addColumn('ip',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                225,
                [
                    'nullable' => false,
                ],
                'Ip'
            )
            ->addColumn('visit',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'First customer visit site per day for countdown'
            )
            ->setComment('Countdown by IP address');

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
