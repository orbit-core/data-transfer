<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Builder\Type;


use OrbitCore\DataTransfer\Domain\Builder\BuilderFactoryInterface;

interface TypeInterface
{
    public function getData(): array;

    public function setBuilderFactory(BuilderFactoryInterface $factory): self;
}
