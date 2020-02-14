<?php
declare(strict_types=1);

namespace OrbitCoreTest\DataTransfer\Domain\Helper;


use OrbitCore\DataTransfer\Domain\Finder\Plugin\SchemaFileFinderPluginInterface;

class TestFinder implements SchemaFileFinderPluginInterface
{
    public function getSchemaFiles(): array
    {
        return [
            __DIR__ . '/Schema/TestSchema.dto.json'
        ];
    }
}
