<?php

namespace SwiftOtter\OrderExport\Console\Command;


use Magento\Framework\Exception\NoSuchEntityException;
use SwiftOtter\OrderExport\Action\ExportOrder;
use SwiftOtter\OrderExport\Model\HeaderData;
use SwiftOtter\OrderExport\Model\HeaderDataFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class OrderExport extends Command
{
    private CollectOrderData $collectOrderData;
    private ExportOrder $exportOrder;

    /**
     * @param HeaderDataFactory $headerDataFactory
     * @param string|null $name
     */
    public function __construct(
        HeaderDataFactory $headerDataFactory,
        ExportOrder $exportOrder,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->headerDataFactory = $headerDataFactory;
        $this->exportOrder = $exportOrder;
    }

    const ARG_NAME_ORDER_ID = 'order-id';
    const OPT_SHIP_DATE = 'ship-date';
    const OPT_NAME_MERCHANT_NOTES = 'notes';

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('order-export:run')
            ->setDescription('Export order to ERP')
            ->addArgument(self::ARG_NAME_ORDER_ID, InputArgument::REQUIRED)
            ->addOption(self::OPT_SHIP_DATE, 'd',
                InputOption::VALUE_OPTIONAL,
                'Shipping date in format YYYY-MM-DD')
            ->addOption(self::OPT_NAME_MERCHANT_NOTES,null,
                InputOption::VALUE_OPTIONAL,
                'Merchant notes');
    }

    /**
     * @throws NoSuchEntityException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $orderId = (int) $input->getArgument(self::ARG_NAME_ORDER_ID);
        $shipDate = $input->getOption(self::OPT_SHIP_DATE);
        $notes = $input->getOption(self::OPT_NAME_MERCHANT_NOTES);

        /**
         * @var HeaderData $headerData
         */
        $headerData = $this->headerDataFactory->create();

        if ($shipDate) {
            $headerData->setShipDate(new \Datetime($shipDate));
        }

        if ($notes) {
           $headerData->setMerchantNotes($notes);
        }

        $result = $this->exportOrder->execute((int) $orderId, $headerData);

        $success = $result['success'] ?? false;

        if($success) {
            $output->writeln(__('Successfully exported order'));
        } else {
            $msg = $result['error'] ?? null;
            if($msg === null){
                $msg = __('Unexpected errors occurred');
            }
            $output->writeln($msg);
            return 1;
        }

        return 0;
    }
}
