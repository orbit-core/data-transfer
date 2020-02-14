<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Processor;


interface DeleteProcessInterface
{
    public function deleteDataTransferObjects(): void;
}
