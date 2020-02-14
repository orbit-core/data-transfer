<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Builder;


use OrbitCore\DataTransfer\Domain\Builder\Type\TypeInterface;
use OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface;

interface TransferBuilderInterface
{
    public function getData(): array;

    /**
     * @param string $name
     *
     * @return \OrbitCore\DataTransfer\Domain\Builder\Type\TransferTypeInterface
     */
    public function transfer(string $name, DataTransferConfigInterface $config = null): TypeInterface;
}
