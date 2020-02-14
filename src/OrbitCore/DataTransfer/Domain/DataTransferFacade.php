<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain;


use OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface;
use OrbitCore\Infrastructure\Facade\AbstractFacade;
use OrbitCore\Infrastructure\Factory\FactoryInterface;

/**
 * @method \OrbitCore\DataTransfer\Domain\DataTransferDomainFactory getFactory()
 */
class DataTransferFacade extends AbstractFacade implements DataTransferFacadeInterface
{
    public function deleteDataTransferObjects(): void
    {
        $this->getFactory()
             ->createDeleteProcess()
             ->deleteDataTransferObjects();
    }

    public function generateDataTransferObjects(): void
    {
        $this->getFactory()
             ->createGenerateProcess()
             ->generateDataTransferObjects();
    }

    public function generateDataTransferObjectsByConfig(DataTransferConfigInterface $config): void
    {
        $this->getFactory()
             ->createGenerateProcess()
             ->generateDataTransferObjects($config);
    }
}
