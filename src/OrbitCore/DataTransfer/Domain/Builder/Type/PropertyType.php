<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Builder\Type;


use OrbitCore\DataTransfer\Domain\Builder\BuilderFactoryInterface;

class PropertyType implements PropertyTypeInterface
{
    /**
     * @var \OrbitCore\DataTransfer\Domain\Builder\BuilderFactoryInterface
     */
    protected $factory;

    /**
     * @var array
     */
    protected $data = [
        'singleName' => '',
        'allowNull' => false,
        'isCollection' => false,
        'type' => 'string'
    ];

    protected $name;

    /**
     * PropertyType constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->data['singleName'] = $name;
    }

    public function allowNull(bool $allowNull = true): PropertyTypeInterface
    {
        $this->data['allowNull'] = $allowNull;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function isCollection(bool $isCollection = true): PropertyTypeInterface
    {
        $this->data['isCollection'] = $isCollection;

        return $this;
    }

    public function setBuilderFactory(BuilderFactoryInterface $factory): TypeInterface
    {
        $this->factory = $factory;

        return $this;
    }

    public function setSingleName(string $singleName): PropertyTypeInterface
    {
        $this->data['singleName'] = $singleName;

        return $this;
    }

    public function setType(string $type): PropertyTypeInterface
    {
        $this->data['type'] = $type;

        return $this;
    }
}
