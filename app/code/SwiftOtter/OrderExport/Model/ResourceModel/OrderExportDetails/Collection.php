<?php

declare(strict_types=1);

namespace SwiftOtter\OrderExport\Model\ResourceModel\OrderExportDetails;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SwiftOtter\OrderExport\Model\OrderExportDetails;
use SwiftOtter\OrderExport\Model\ResourceModel\OrderExportDetails as OrderExportResource;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(OrderExportDetails::class, OrderExportResource::class);
    }
}
