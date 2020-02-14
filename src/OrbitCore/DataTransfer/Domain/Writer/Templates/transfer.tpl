<?php declare(strict_types=1);

namespace {% namespace %};

use \OrbitCore\DataTransfer\Domain\DataTransfer\AbstractDataTransfer;
use \OrbitCore\DataTransfer\Domain\DataTransfer\RequiredPropertyNotDefinedException;

final class {% transferName %}Dto extends AbstractDataTransfer
{
{% properties %}
{% methods %}

    public function getProperties(): array
    {
        return {% transferData %};
    }
}
