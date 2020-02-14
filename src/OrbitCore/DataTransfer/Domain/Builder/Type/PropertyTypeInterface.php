<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Builder\Type;


interface PropertyTypeInterface extends TypeInterface
{
    public function allowNull(bool $allowNull = true): self;

    public function isCollection(bool $isCollection = true): self;

    public function setSingleName(string $singleName): self;

    public function setType(string $type): self;
}
