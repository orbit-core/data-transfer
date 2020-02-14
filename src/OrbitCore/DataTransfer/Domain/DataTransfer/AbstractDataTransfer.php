<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\DataTransfer;


abstract class AbstractDataTransfer implements DataTransferInterface
{
    /**
     * @var bool
     */
    protected $modified = false;

    protected $modifiedProperties = [];

    public function fromArray(array $data): void
    {
        foreach ($data as $fieldName => $fieldValue) {

        }
    }

    abstract public function getProperties(): array;

    public function isModified(): bool
    {
        return $this->modified;
    }

    public function setModified(string $property): void
    {
        $this->modified = true;
        $this->modifiedProperties[] = $property;
    }

    public function modifiedToArray(): array
    {
        return $this->convertPropertiesToArray($this->modifiedProperties);
    }

    public function toArray(): array
    {
        return $this->convertPropertiesToArray(array_keys($this->getProperties()));
    }

    protected function convertPropertiesToArray(array $fields): array
    {
        $data = [];
        foreach ($fields as $fieldName) {
            $data[$fieldName] = $this->valueToArray($this->{ $fieldName });
        }

        return $data;
    }

    /**
     * @param $value
     *
     * @return array
     */
    protected function convertFromArray($value): array
    {
        $list = [];
        foreach ($value as $item) {
            $list[] = $this->valueToArray($item);
        }

        $value = $list;
        return $value;
    }

    protected function convertFromObject(object $value)
    {
        if ($value instanceof DataTransferInterface) {
            return $value->toArray();
        }

        return $value;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    protected function valueToArray($value)
    {
        if (is_array($value)) {
            $value = $this->convertFromArray($value);
        } elseif (is_object($value)) {
            $value = $this->convertFromObject($value);
        }

        return $value;
    }
}
