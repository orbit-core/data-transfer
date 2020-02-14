<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain;


use OrbitCore\Infrastructure\Container\ContainerInterface;
use OrbitCore\Infrastructure\Dependency\Domain\AbstractDomainDependencyProvider;

class DataTransferDomainDependencyProvider extends AbstractDomainDependencyProvider
{
    public const DATA_TRANSFER_CONFIG_PLUGINS = 'DATA_TRANSFER_CONFIG_PLUGINS';

    public function provideDomainDependencies(ContainerInterface $container): ContainerInterface
    {
        $container = $this->addDataTransferConfigPlugins($container);

        return $container;
    }

    protected function addDataTransferConfigPlugins(ContainerInterface $container): ContainerInterface
    {
        $container->set(static::DATA_TRANSFER_CONFIG_PLUGINS, function (ContainerInterface $container) {
            return $this->getDataTransferConfigPlugins();
        });

        return $container;
    }

    /**
     * @return \OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface[]
     */
    protected function getDataTransferConfigPlugins(): array
    {
        return [];
    }
}
