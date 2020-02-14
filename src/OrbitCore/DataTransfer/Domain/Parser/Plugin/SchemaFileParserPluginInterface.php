<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Parser\Plugin;


use OrbitCore\DataTransfer\Domain\Builder\TransferBuilderInterface;
use OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface;

interface SchemaFileParserPluginInterface
{
    public function parseSchemaFile(string $schemaFilePath, DataTransferConfigInterface $config, TransferBuilderInterface $builder): TransferBuilderInterface;
}
