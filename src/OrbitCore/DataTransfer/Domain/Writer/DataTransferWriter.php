<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Writer;


use OrbitCore\DataTransfer\Domain\Builder\TransferBuilderInterface;
use OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface;
use OrbitCore\DataTransfer\Domain\Writer\Exception\TypeIsNotValidException;

class DataTransferWriter implements DataTransferWriterInterface
{
    protected const TEMPLATE_TRANSFER = 'transfer.tpl';
    protected const TEMPLATE_PROPERTY = 'property.tpl';
    protected const TEMPLATE_METHODS = 'methods.tpl';
    protected const TEMPLATE_COLLECTION = 'collection.tpl';
    protected const FILE_EXTENSION = 'Dto.php';

    public const TRANSFER_CLASS_SUFFIX = 'Dto';

    public const VALID_SIMPLE_TYPES = [
        'int',
        'double',
        'bool',
        'string',
        'array'
    ];

    /**
     * @var string
     */
    protected $defaultTemplatePath;

    /**
     * @var \OrbitCore\DataTransfer\Domain\Writer\TemplateWriterInterface
     */
    protected $templateWriter;

    /**
     * DataTransferWriter constructor.
     *
     * @param string $defaultTemplatePath
     * @param \OrbitCore\DataTransfer\Domain\Writer\TemplateWriterInterface $templateWriter
     */
    public function __construct(
        string $defaultTemplatePath,
        TemplateWriterInterface $templateWriter
    ) {
        $this->defaultTemplatePath = $defaultTemplatePath;
        $this->templateWriter = $templateWriter;
    }

    public function writeTransfer(TransferBuilderInterface $builder): void
    {
        foreach ($builder->getData() as $transferName => $properties) {
            $propertiesContent = '';
            $methodsContent = '';

            $config = $builder->transfer($transferName)->getConfig();

            $transferContent = $this->fetchTransferContent(
                $properties,
                $config,
                $propertiesContent,
                $methodsContent,
                $transferName
            );

            $filename = $transferName . static::FILE_EXTENSION;
            file_put_contents($config->getGeneratePath() . '/' . $filename, $transferContent);
        }
    }

    protected function fetchMethodContents(
        DataTransferConfigInterface $config,
        string $methodsContent,
        string $propertyName,
        array $propertyData
    ): string {
        $data = [
            'propertyName' => $propertyName,
            'propertySingleName' => $propertyData['singleName'],
            'propertyType' => $propertyData['isCollection'] === true ? 'array' : $this->getValidType($propertyData['type'], $config),
            'propertyTypeDoc' => $this->getValidType($propertyData['type'], $config),
            'propertyTypeDocPrefix' => $propertyData['allowNull'] === true ? '?' : '',
            'propertyTypeDocSuffix' => $propertyData['isCollection'] === true ? '[]' : '',
            'propertyTypePrefix' => ($propertyData['allowNull'] === true && $propertyData['isCollection'] !== true) ? '?' : ''
        ];

        $methodsContent .= $this->fetchContent(
            $config,
            static::TEMPLATE_METHODS,
            $data
        );

        if ($propertyData['isCollection']) {
            $methodsContent .= $this->fetchContent(
                $config,
                static::TEMPLATE_COLLECTION,
                $data
            );
        }

        return $methodsContent;
    }

    protected function fetchPropertyContents(
        DataTransferConfigInterface $config,
        string $propertiesContent,
        string $propertyName,
        array $propertyData
    ): string {
        $propertiesContent .= $this->fetchContent($config, static::TEMPLATE_PROPERTY, [
            'propertyName' => $propertyName,
            'propertyType' => $this->getValidType($propertyData['type'], $config),
            'propertyTypePrefix' => $propertyData['allowNull'] === true ? '?' : '',
            'propertyTypeSuffix' => $propertyData['isCollection'] === true ? '[]' : ''
        ]);
        return $propertiesContent;
    }

    protected function fetchTransferContent(
        array $properties,
        DataTransferConfigInterface $config,
        string $propertiesContent,
        string $methodsContent,
        string $transferName
    ): string {
        foreach ($properties as $propertyName => $propertyData) {
            $propertiesContent = $this->fetchPropertyContents($config, $propertiesContent, $propertyName,
                $propertyData);
            $methodsContent = $this->fetchMethodContents($config, $methodsContent, $propertyName, $propertyData);
            $properties[$propertyName]['validType'] = $this->getValidType($propertyData['type'], $config);
        }

        return $this->fetchContent($config, static::TEMPLATE_TRANSFER, [
            'methods' => $methodsContent,
            'namespace' => $config->getNamespace(),
            'properties' => $propertiesContent,
            'transferData' => var_export($properties, true),
            'transferName' => $transferName,
            'transferSuffix' => static::TRANSFER_CLASS_SUFFIX
        ]);
    }

    /**
     * @param string $type
     *
     * @return string
     */
    protected function getValidType(string $type, DataTransferConfigInterface $config): string
    {
        if (in_array($type, static::VALID_SIMPLE_TYPES)) {
            return $type;
        }

        if (class_exists($type)) {
            return $type;
        }

        return '\\' . $config->getNamespace() . '\\' . $type . static::TRANSFER_CLASS_SUFFIX;
    }

    protected function fetchContent(DataTransferConfigInterface $config, string $template, array $data): string
    {
        $templatePath = $config->getTemplatePath();
        if (!$templatePath) {
            $templatePath = $this->defaultTemplatePath;
        }

        return $this->templateWriter->fetchContent($templatePath . '/' . $template, $data);
    }
}
