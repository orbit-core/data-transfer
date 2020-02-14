<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain;


use OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface;

interface DataTransferFacadeInterface
{
    public function deleteDataTransferObjects(): void;

    public function generateDataTransferObjects(): void;

    public function generateDataTransferObjectsByConfig(DataTransferConfigInterface $config): void;
}
