<?php
declare(strict_types=1);

namespace OrbitCore\DataTransfer\Domain\Processor;


class DeleteProcess implements DeleteProcessInterface
{
    /**
     * @var \OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface[]
     */
    protected $configPlugins;

    /**
     * @param \OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface[] $configPlugins
     */
    public function __construct(array $configPlugins)
    {
        $this->configPlugins = $configPlugins;
    }

    public function deleteDataTransferObjects(): void
    {
        foreach ($this->configPlugins as $configPlugin) {
            foreach (glob($configPlugin->getGeneratePath() . '/*Dto.php') as $dtoFile) {
                unlink($dtoFile);
            }
        }
    }
}
