<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain;


use OrbitCore\DataTransfer\Domain\Builder\BuilderFactory;
use OrbitCore\DataTransfer\Domain\Builder\BuilderFactoryInterface;
use OrbitCore\DataTransfer\Domain\Builder\TransferBuilder;
use OrbitCore\DataTransfer\Domain\Builder\TransferBuilderInterface;
use OrbitCore\DataTransfer\Domain\Processor\DeleteProcess;
use OrbitCore\DataTransfer\Domain\Processor\DeleteProcessInterface;
use OrbitCore\DataTransfer\Domain\Processor\GenerateProcess;
use OrbitCore\DataTransfer\Domain\Processor\GenerateProcessInterface;
use OrbitCore\DataTransfer\Domain\Writer\DataTransferWriter;
use OrbitCore\DataTransfer\Domain\Writer\DataTransferWriterInterface;
use OrbitCore\DataTransfer\Domain\Writer\TemplateWriter;
use OrbitCore\DataTransfer\Domain\Writer\TemplateWriterInterface;
use OrbitCore\Infrastructure\Factory\Domain\AbstractDomainFactory;

/**
 * @method \OrbitCore\DataTransfer\DataTransferConfig getConfig()
 */
class DataTransferDomainFactory extends AbstractDomainFactory implements DataTransferDomainFactoryInterface
{

    public function createBuilderFactory(): BuilderFactoryInterface
    {
        return new BuilderFactory();
    }

    public function createDeleteProcess(): DeleteProcessInterface
    {
        return new DeleteProcess(
            $this->getDataTransferConfigPlugins()
        );
    }

    public function createGenerateProcess(): GenerateProcessInterface
    {
        return new GenerateProcess(
            $this->getDataTransferConfigPlugins(),
            $this->createTransferBuilder(),
            $this->createWriter()
        );
    }

    public function createTemplateWriter(): TemplateWriterInterface
    {
        return new TemplateWriter();
    }

    public function createTransferBuilder(): TransferBuilderInterface
    {
        return new TransferBuilder(
            $this->createBuilderFactory()
        );
    }

    public function createWriter(): DataTransferWriterInterface
    {
        return new DataTransferWriter(
            $this->getConfig()->getTemplatePath(),
            $this->createTemplateWriter()
        );
    }

    /**
     * @return \OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface[]
     */
    public function getDataTransferConfigPlugins(): array
    {
        return $this->getDependency(DataTransferDomainDependencyProvider::DATA_TRANSFER_CONFIG_PLUGINS);
    }


}
