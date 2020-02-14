<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\DataTransfer;


use OrbitCore\DataTransfer\Domain\Writer\DataTransferWriter;

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
            $fieldConfig = $this->getProperties()[$fieldName];

            if ($fieldConfig['isCollection']) {
                $this->fromArrayToCollection($fieldValue, $fieldConfig);
            } else {
                $this->fromArrayToSingleField($fieldConfig, $fieldName, $fieldValue);
            }
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
     * @param $fieldValue
     * @param $fieldConfig
     */
    protected function fromArrayToCollection($fieldValue, $fieldConfig): void
    {
        if (is_array($fieldValue)) {
            if (in_array($fieldConfig['type'], DataTransferWriter::VALID_SIMPLE_TYPES)) {
                foreach ($fieldValue as $fieldItem) {
                    $this->{"add" . $fieldConfig['singleName']}($fieldItem);
                }
            } else {
                $this->fromArrayToCollectionDataTransferObject($fieldValue, $fieldConfig);
            }
        }
    }

    /**
     * @param $fieldValue
     * @param $fieldConfig
     */
    protected function fromArrayToCollectionDataTransferObject($fieldValue, $fieldConfig): void
    {
        if (!class_exists($fieldConfig['type'])) {
            if (class_exists($fieldConfig['validType']) && is_array($fieldValue)) {
                foreach ($fieldValue as $fieldItem) {
                    $subDto = new $fieldConfig['validType']();
                    $subDto->fromArray($fieldItem);
                    $this->{"add" . $fieldConfig['singleName']}($subDto);
                }
            }
        } else {
            foreach ($fieldValue as $fieldItem) {
                $this->{"add" . $fieldConfig['singleName']}($fieldItem);
            }
        }
    }

    /**
     * @param $fieldConfig
     * @param $fieldName
     * @param $fieldValue
     */
    protected function fromArrayToSingleField($fieldConfig, $fieldName, $fieldValue): void
    {
        if (in_array($fieldConfig['type'], DataTransferWriter::VALID_SIMPLE_TYPES)) {
            $this->{"set" . $fieldName}($fieldValue);
        } else {
            if (!class_exists($fieldConfig['type'])) {
                if (class_exists($fieldConfig['validType']) && is_array($fieldValue)) {
                    $subDto = new $fieldConfig['validType']();
                    $subDto->fromArray($fieldValue);
                    $this->{"set" . $fieldName}($subDto);
                }
            } else {
                $this->{"set" . $fieldName}($fieldValue);
            }
        }
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
