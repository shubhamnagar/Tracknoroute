<?php
namespace Raveinfosys\Tracknoroute\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('tracknoroute'))
            ->addColumn(
                'id',
                Table::TYPE_SMALLINT,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'ID'
            )
            ->addColumn('url', Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'URL')
            ->addColumn('status', Table::TYPE_BOOLEAN, null, ['nullable' => false], 'Status')
            ->addColumn('count', Table::TYPE_INTEGER, 11, ['nullable' => false], 'Count')
            ->addColumn('remote_address', Table::TYPE_TEXT, null, ['nullable' => true, 'default' => ''], 'Remote Address')
            ->addColumn('referral_url', Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'Refferal URL')
            ->addColumn('created_date', Table::TYPE_DATETIME, null, ['nullable' => false], 'Creation Date')
            ->addColumn('updated_date', Table::TYPE_DATETIME, null, ['nullable' => false], 'Update Date');

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
