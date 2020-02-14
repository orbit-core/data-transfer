<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Processor;


use OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface;

interface GenerateProcessInterface
{
    public function generateDataTransferObjects(DataTransferConfigInterface $config = null): void;
}
