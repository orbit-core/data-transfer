<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Builder;


use OrbitCore\DataTransfer\Domain\Builder\Type\TransferTypeInterface;
use OrbitCore\DataTransfer\Domain\Builder\Type\TypeInterface;
use OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface;

class TransferBuilder implements TransferBuilderInterface
{
    /**
     * @var \OrbitCore\DataTransfer\Domain\Builder\BuilderFactoryInterface
     */
    protected $factory;

    /**
     * @var \OrbitCore\DataTransfer\Domain\Builder\Type\TransferType[]
     */
    protected $transferObjects;

    /**
     * TransferBuilder constructor.
     *
     * @param \OrbitCore\DataTransfer\Domain\Builder\BuilderFactoryInterface $factory
     */
    public function __construct(BuilderFactoryInterface $factory)
    {
        $this->factory = $factory;
        $this->transferObjects = [];
    }

    public function getData(): array
    {
        return array_map(
            function (TransferTypeInterface $transfers) {
                return $transfers->getData();
            },
            $this->transferObjects
        );
    }

    public function transfer(string $name, DataTransferConfigInterface $config = null): TypeInterface
    {
        if (!isset($this->transferObjects[$name])) {
            $this->transferObjects[$name] = $this->factory->createTransferType($name, $config);
        }

        return $this->transferObjects[$name];
    }
}
