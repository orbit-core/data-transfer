<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Processor\Config;


use OrbitCore\DataTransfer\Domain\Finder\Plugin\SchemaFileFinderPluginInterface;
use OrbitCore\DataTransfer\Domain\Parser\Plugin\SchemaFileParserPluginInterface;

interface DataTransferConfigInterface
{
    public function getFinder(): SchemaFileFinderPluginInterface;

    public function getGeneratePath(): string;

    public function getNamespace(): string;

    public function getParser(): SchemaFileParserPluginInterface;

    public function getTemplatePath(): string;
}
