<?php
/**
 * OrderExportDetails
 *
 * @copyright Copyright © 2024 Mohamed Tawfik. All rights reserved.
 * @author    mohd.itc4@gmail.com
 */

namespace SwiftOtter\OrderExport\Model;


use Magento\Framework\Model\AbstractModel;
use SwiftOtter\OrderExport\Api\Data\OrderExportDetailsInterface;

class OrderExportDetails extends AbstractModel  implements OrderExportDetailsInterface
{
    protected function _construct()
    {
        $this->_init(\SwiftOtter\OrderExport\Model\ResourceModel\OrderExportDetails::class);
    }
    public function getOrderId(): ?int {
        return ($this->hasData('order_id')? (int) $this->getData('order_id'): null);
    }
    public function setOrderId(int $orderId): OrderExportDetailsInterface{
        $this->setData('order_id', $orderId);
        return $this;
    }
    public function getShipOn(): ?\DateTime{
        $dateStr = $this->getData('ship_on');
        return ($dateStr) ? new \DateTime($dateStr): null;
    }
    public function setShipOn(\DateTime $shipOn): OrderExportDetailsInterface {
        $this->setData('ship_on', $shipOn->format('Y-m-d'));
        return $this;
    }
    public function getMerchantNotes(): string{
        return (string) $this->getData('merchant_notes');
    }
    public function setMerchantNotes(string $notes): OrderExportDetailsInterface{
         $this->setData('merchant_notes', $notes);
         return $this;
    }
    public function getExportedAt(): ?\DateTime{
        $dateStr = $this->getData('exported_at');
        return ($dateStr) ? new \DateTime($dateStr): null;
    }
    public function setExportedAt(\DateTime $exportedAt): OrderExportDetailsInterface {
        $this->setData('exported_at', $exportedAt->format('Y-m-d H:i:s'));
        return $this;
    }
    public function hasBeenExported(): bool{
        return (bool) $this->getData('exported_at');
    }
}
