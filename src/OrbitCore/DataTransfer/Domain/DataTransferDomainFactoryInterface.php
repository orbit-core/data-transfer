<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain;


use OrbitCore\DataTransfer\Domain\Builder\BuilderFactoryInterface;
use OrbitCore\DataTransfer\Domain\Builder\TransferBuilderInterface;
use OrbitCore\DataTransfer\Domain\Processor\DeleteProcessInterface;
use OrbitCore\DataTransfer\Domain\Processor\GenerateProcessInterface;
use OrbitCore\DataTransfer\Domain\Writer\DataTransferWriterInterface;
use OrbitCore\DataTransfer\Domain\Writer\TemplateWriterInterface;

interface DataTransferDomainFactoryInterface
{
    public function createBuilderFactory(): BuilderFactoryInterface;

    public function createDeleteProcess(): DeleteProcessInterface;

    public function createGenerateProcess(): GenerateProcessInterface;

    public function createTemplateWriter(): TemplateWriterInterface;

    public function createTransferBuilder(): TransferBuilderInterface;

    public function createWriter(): DataTransferWriterInterface;

    /**
     * @return \OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface[]
     */
    public function getDataTransferConfigPlugins(): array;
}
