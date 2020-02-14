<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Writer;


interface TemplateWriterInterface
{
    public function fetchContent(string $templateFile, array $data): string;
}
