<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Builder;


use OrbitCore\DataTransfer\Domain\Builder\Type\PropertyType;
use OrbitCore\DataTransfer\Domain\Builder\Type\TransferType;
use OrbitCore\DataTransfer\Domain\Builder\Type\TypeInterface;
use OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface;

class BuilderFactory implements BuilderFactoryInterface
{
    public function createPropertyType(string $name): TypeInterface
    {
        return (new PropertyType($name))->setBuilderFactory($this);
    }

    public function createTransferType(string $name, DataTransferConfigInterface $config): TypeInterface
    {
        return (new TransferType($name, $config))->setBuilderFactory($this);
    }
}
