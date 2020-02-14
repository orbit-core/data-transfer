<?php
declare(strict_types=1);

namespace OrbitCoreTest\DataTransfer\Domain\Builder;


use Codeception\TestCase\Test;
use OrbitCore\DataTransfer\Domain\Builder\BuilderFactory;
use OrbitCore\DataTransfer\Domain\Builder\TransferBuilder;
use OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface;
use OrbitCoreTest\DataTransfer\Domain\Generate\ExampleDto;
use OrbitCoreTest\DataTransfer\Domain\Generate\SecondTestDto;

/**
 * @group OrbitCore
 * @group DataTransfer
 * @group Domain
 * @group Builder
 * @group TransferBuilder
 * @group Integration
 */
class TransferBuilderTest extends Test
{
    public function testTransferBuilding()
    {
        $transferBuilder = new TransferBuilder(
            new BuilderFactory()
        );

        /** @var \OrbitCore\DataTransfer\Domain\Processor\Config\DataTransferConfigInterface $config */
        $config = $this->makeEmpty(DataTransferConfigInterface::class);

        $transferBuilder->transfer('testOne', $config)->property('propOne')->setType('int');
        $transferBuilder->transfer('testOne', $config)->property('propTwo')->setType('bool')->allowNull();
        $transferBuilder->transfer('testOne', $config)->property('propThrees')->setType('string')->setSingleName('propThree')->isCollection();
        $transferBuilder->transfer('testTwo', $config)->property('secondTransferProperty')->setType('testOne')->allowNull();

        $this->assertEquals(
            [
                'testOne' => [
                    'propOne' => [
                        'allowNull' => false,
                        'singleName' => 'propOne',
                        'isCollection' => false,
                        'type' => 'int'
                    ],
                    'propTwo' => [
                        'allowNull' => true,
                        'singleName' => 'propTwo',
                        'isCollection' => false,
                        'type' => 'bool'
                    ],
                    'propThrees' => [
                        'allowNull' => false,
                        'singleName' => 'propThree',
                        'isCollection' => true,
                        'type' => 'string'
                    ]
                ],
                'testTwo' => [
                    'secondTransferProperty' => [
                        'allowNull' => true,
                        'singleName' => 'secondTransferProperty',
                        'isCollection' => false,
                        'type' => 'testOne'
                    ]
                ]
            ],
            $transferBuilder->getData()
        );
    }
}
