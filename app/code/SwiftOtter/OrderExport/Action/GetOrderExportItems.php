<?php
/**
 * GetOrderExportItems
 *
 * @copyright Copyright © 2023 Mohamed Tawfik. All rights reserved.
 * @author    mohd.itc4@gmail.com
 */

namespace SwiftOtter\OrderExport\Action;


use Magento\Sales\Api\Data\OrderInterface;

class GetOrderExportItems
{

    private array $allowedTypes;

    public function __construct(
        array $allowedTypes = []
    )
    {
        $this->allowedTypes = $allowedTypes;
    }

    public function execute(OrderInterface $order): array
    {
        $items = [];
        foreach($order->getItems() as $orderItem) {
            if(in_array($orderItem->getProductType(), $this->allowedTypes)) {
                $items[] = $orderItem;
            }
        }
        return $items;
    }
}
