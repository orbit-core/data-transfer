<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Builder\Type;


use OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface;

interface TransferTypeInterface extends TypeInterface
{
    public function getConfig(): DataTransferConfigInterface;

    public function property(string $name): PropertyTypeInterface;
}
