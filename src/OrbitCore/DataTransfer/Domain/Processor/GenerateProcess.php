<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Processor;


use OrbitCore\DataTransfer\Domain\Builder\TransferBuilderInterface;
use OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface;
use OrbitCore\DataTransfer\Domain\Writer\DataTransferWriterInterface;

class GenerateProcess implements GenerateProcessInterface
{
    /**
     * @var \OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface[]
     */
    protected $configPlugins;

    /**
     * @var \OrbitCore\DataTransfer\Domain\Builder\TransferBuilderInterface
     */
    protected $builder;

    /**
     * @var \OrbitCore\DataTransfer\Domain\Writer\DataTransferWriterInterface
     */
    protected $writer;

    /**
     * GenerateProcess constructor.
     *
     * @param \OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface[] $configPlugins
     * @param \OrbitCore\DataTransfer\Domain\Builder\TransferBuilderInterface $builder
     * @param \OrbitCore\DataTransfer\Domain\Writer\DataTransferWriterInterface $writer
     */
    public function __construct(
        array $configPlugins,
        TransferBuilderInterface $builder,
        DataTransferWriterInterface $writer
    ) {
        $this->configPlugins = $configPlugins;
        $this->builder = $builder;
        $this->writer = $writer;
    }

    public function generateDataTransferObjects(DataTransferConfigInterface $config = null): void
    {
        if ($config !== null) {
            $this->processConfigs([$config]);
        } else {
            $this->processConfigs($this->configPlugins);
        }
    }

    /**
     * @param \OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface[] $configs
     */
    protected function processConfigs(array $configs): void
    {
        foreach ($configs as $config) {
            foreach ($config->getFinder()->getSchemaFiles() as $schemaFile) {
                $this->builder = $config->getParser()->parseSchemaFile($schemaFile, $config, $this->builder);
            }
        }

        $this->writer->writeTransfer($this->builder);
    }
}
