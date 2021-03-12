<?php

declare(strict_types=1);

namespace VitaliiLuka\RegularCustomer\Setup\Patch\Schema;

use Magento\Framework\DB\Adapter\AdapterInterface;

class DropUniqueIndex implements \Magento\Framework\Setup\Patch\SchemaPatchInterface
{
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface $schemaSetup
     */
    private $schemaSetup;

    /**
     * RemoveUniqueIndex constructor.
     * @param \Magento\Framework\Setup\SchemaSetupInterface $schemaSetup
     */

    public function __construct(
        \Magento\Framework\Setup\SchemaSetupInterface $schemaSetup
    ) {
        $this->schemaSetup = $schemaSetup;
    }

    /**
     * @inheritDoc
     */
    public function apply(): void
    {
        $this->schemaSetup->getConnection()->startSetup();
        $this->schemaSetup->getConnection()->dropIndex(
            $this->schemaSetup->getTable('vitalii_luka_regular_customer_request'),
            $this->schemaSetup->getIdxName(
                'vitalii_luka_regular_customer_request',
                ['email', 'website_id'],
                AdapterInterface::INDEX_TYPE_UNIQUE
            )
        );
        $this->schemaSetup->getConnection()->endSetup();
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases(): array
    {
        return [];
    }
}
