<?php
/**
 * OrderExportDetails
 *
 * @copyright Copyright © 2024 Mohamed Tawfik. All rights reserved.
 * @author    mohd.itc4@gmail.com
 */

namespace SwiftOtter\OrderExport\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class OrderExportDetails extends AbstractDb
{

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('sales_order_export', 'id');
    }
}
