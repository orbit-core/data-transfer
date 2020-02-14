<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Finder\Plugin;


interface SchemaFileFinderPluginInterface
{
    public function getSchemaFiles(): array;
}
