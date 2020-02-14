<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer;


use OrbitCore\Infrastructure\Config\AbstractConfig;

class DataTransferConfig extends AbstractConfig
{
    public const DATA_TRANSFER_TEMPLATE_PATH = 'DATA_TRANSFER_TEMPLATE_PATH';

    public function getTemplatePath(): string
    {
        return $this->get(static::DATA_TRANSFER_TEMPLATE_PATH);
    }
}
