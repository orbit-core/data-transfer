<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Writer;


class TemplateWriter implements TemplateWriterInterface
{
    protected const REPLACE_PATTERN = '{%% %s %%}';

    public function fetchContent(string $templateFile, array $data): string
    {
        $content = file_get_contents($templateFile);
        $content = $this->replaceData($data, $content);

        return $content;
    }

    /**
     * @param array $data
     * @param string $content
     *
     * @return string
     */
    protected function replaceData(array $data, string $content): string
    {
        $fields = [];
        $values = [];
        foreach ($data as $field => $value) {
            $fields[] = sprintf(static::REPLACE_PATTERN, $field);
            $values[] = $value;
        }

        return str_replace($fields, $values, $content);
    }
}
