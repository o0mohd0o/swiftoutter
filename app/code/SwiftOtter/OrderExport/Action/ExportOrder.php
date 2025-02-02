<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\OrderExport\Action;

use GuzzleHttp\Exception\GuzzleException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use SwiftOtter\OrderExport\Model\HeaderData;
use SwiftOtter\OrderExport\Model\Config;
use Magento\Framework\Exception\NoSuchEntityException;
use SwiftOtter\OrderExport\Action\PushDetailsToWebservice;

class ExportOrder
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;
    /** @var Config */
    private $config;
    /** @var CollectOrderData */
    private $collectOrderData;
    /** @var \SwiftOtter\OrderExport\Action\PushDetailsToWebservice */
    private $pushDetailsToWebservice;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        Config $config,
        CollectOrderData $collectOrderData,
        PushDetailsToWebservice $pushDetailsToWebservice
    ) {
        $this->orderRepository = $orderRepository;
        $this->config = $config;
        $this->collectOrderData = $collectOrderData;
        $this->pushDetailsToWebservice = $pushDetailsToWebservice;
    }

    /**
     * @throws LocalizedException
     * @throws NoSuchEntityException
     * @throws GuzzleException
     */
    public function execute(int $orderId, HeaderData $headerData): array
    {
        $order = $this->orderRepository->get($orderId);

        if (!$this->config->isEnabled(ScopeInterface::SCOPE_STORE, $order->getStoreId())) {
            throw new LocalizedException(__('Order export is disabled'));
        }

        $results = ['success' => false, 'error' => null];

        $exportData = $this->collectOrderData->execute($order, $headerData);

        try {
            $results['success'] = $this->pushDetailsToWebservice->execute($exportData, $order);
            // TODO Save export details
        } catch (\Throwable $e) {
            $results['error'] = $e->getMessage();
        }

        return $results;
    }
}
