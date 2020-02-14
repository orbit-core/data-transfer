<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Writer;


use OrbitCore\DataTransfer\Domain\Builder\TransferBuilderInterface;
use OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface;

interface DataTransferWriterInterface
{
    public function writeTransfer(TransferBuilderInterface $builder): void;
}
