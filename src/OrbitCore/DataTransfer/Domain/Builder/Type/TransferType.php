<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Builder\Type;


use OrbitCore\DataTransfer\Domain\Builder\BuilderFactoryInterface;
use OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface;

class TransferType implements TransferTypeInterface
{
    /**
     * @var \OrbitCore\DataTransfer\Domain\Builder\BuilderFactoryInterface
     */
    protected $factory;

    /**
     * @var \OrbitCore\DataTransfer\Domain\Builder\Type\PropertyType[]
     */
    protected $properties;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface
     */
    protected $config;

    /**
     * TransferType constructor.
     *
     * @param string $name
     */
    public function __construct(string $name, DataTransferConfigInterface $config)
    {
        $this->name = $name;
        $this->config = $config;
        $this->properties = [];
    }

    public function getConfig(): DataTransferConfigInterface
    {
        return $this->config;
    }

    public function getData(): array
    {
        return array_map(
            function (PropertyTypeInterface $property) {
                return $property->getData();
            },
            $this->properties
        );
    }

    public function property(string $name): PropertyTypeInterface
    {
        if (!isset($this->properties[$name])) {
            $this->properties[$name] = $this->factory->createPropertyType($name);
        }

        return $this->properties[$name];
    }

    public function setBuilderFactory(BuilderFactoryInterface $factory): TypeInterface
    {
        $this->factory = $factory;

        return $this;
    }

}
