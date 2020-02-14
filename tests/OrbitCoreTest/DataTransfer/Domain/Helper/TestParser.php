<?php
declare(strict_types=1);

namespace OrbitCoreTest\DataTransfer\Domain\Helper;


use OrbitCore\DataTransfer\Domain\Builder\TransferBuilderInterface;
use OrbitCore\DataTransfer\Domain\Parser\Plugin\SchemaFileParserPluginInterface;
use OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface;

class TestParser implements SchemaFileParserPluginInterface
{
    public function parseSchemaFile(
        string $schemaFilePath,
        DataTransferConfigInterface $config,
        TransferBuilderInterface $builder
    ): TransferBuilderInterface {
        $data = json_decode(file_get_contents($schemaFilePath), true);

        foreach ($data['transfers'] as $transfer) {
            $dto = $builder->transfer($transfer['name'], $config);
            foreach ($transfer['properties'] as $property) {
                $dtoProperty = $dto->property($property['name']);
                $dtoProperty
                    ->setSingleName($property['singleName'] ?? $property['name'])
                    ->allowNull($property['allowNull'] ?? false)
                    ->isCollection($property['collection'] ?? false)
                    ->setType($property['type'] ?? 'string');
            }
        }

        return $builder;
    }
}
