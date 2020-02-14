<?php
declare(strict_types=1);

namespace OrbitCoreTest\DataTransfer\Domain\Helper;


use OrbitCore\DataTransfer\Domain\Finder\Plugin\SchemaFileFinderPluginInterface;
use OrbitCore\DataTransfer\Domain\Parser\Plugin\SchemaFileParserPluginInterface;
use OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface;

class DataTransferTestConfig implements DataTransferConfigInterface
{
    public function getFinder(): SchemaFileFinderPluginInterface
    {
        return new TestFinder();
    }

    public function getGeneratePath(): string
    {
        return dirname(__DIR__) . '/Generate';
    }

    public function getNamespace(): string
    {
        return 'OrbitCoreTest\\DataTransfer\\Domain\\Generate';
    }

    public function getParser(): SchemaFileParserPluginInterface
    {
        return new TestParser();
    }

    public function getTemplatePath(): string
    {
        return dirname(__DIR__, 5) . '/src/OrbitCore/DataTransfer/Domain/Writer/Templates';
    }
}
