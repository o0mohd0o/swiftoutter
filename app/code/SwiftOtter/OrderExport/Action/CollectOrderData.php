<?php

namespace SwiftOtter\OrderExport\Action;


use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\TestFramework\Exception\NoSuchActionException;
use SwiftOtter\OrderExport\Api\OrderDataCollectorInterface;
use SwiftOtter\OrderExport\Model\HeaderData;



class CollectOrderData
{
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;
    /**
     * @var OrderDataCollectorInterface[]
     */
    private array $collectors;

    /**
     * @param array $collectors
     */
    public function __construct(
        array $collectors = []
    )
    {
        $this->collectors = $collectors;
    }

    /**
     * @throws NoSuchActionException
     */
    public function execute(OrderInterface $order, HeaderData $headerData): array
    {

        $output =  [];
        foreach($this->collectors as $collector) {
            $output = array_merge_recursive($output, $collector->collect($order, $headerData));
        }
        return $output;
    }
}
