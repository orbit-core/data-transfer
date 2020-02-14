<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Builder;


use OrbitCore\DataTransfer\Domain\Builder\Type\TransferTypeInterface;
use OrbitCore\DataTransfer\Domain\Builder\Type\TypeInterface;
use OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface;

interface BuilderFactoryInterface
{
    public function createPropertyType(string $name): TypeInterface;

    public function createTransferType(string $name, DataTransferConfigInterface $config): TypeInterface;
}
