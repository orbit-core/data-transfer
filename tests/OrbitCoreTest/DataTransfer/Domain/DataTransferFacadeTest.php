<?php
declare(strict_types=1);

namespace OrbitCoreTest\DataTransfer\Domain;


use Codeception\TestCase\Test;
use OrbitCore\DataTransfer\Domain\DataTransfer\RequiredPropertyNotDefinedException;
use OrbitCore\DataTransfer\Domain\DataTransferDomainDependencyProvider;
use OrbitCoreTest\DataTransfer\Domain\Generate\ExampleDto;
use OrbitCoreTest\DataTransfer\Domain\Generate\SecondTestDto;
use OrbitCoreTest\DataTransfer\Domain\Helper\DataTransferTestConfig;

class DataTransferFacadeTest extends Test
{
    /**
     * @var \OrbitCoreTest\DataTransfer\DataTransferDomainTester
     */
    protected $tester;

    public function testGenerateAndDeleteDto()
    {
        $facade = $this->tester->createFacade(
            [
                DataTransferDomainDependencyProvider::DATA_TRANSFER_CONFIG_PLUGINS => [
                    new DataTransferTestConfig()
                ]
            ]
        );

        $facade->generateDataTransferObjects();

        $this->assertFileExists(__DIR__ . '/Generate/ExampleDto.php');
        $this->assertFileExists(__DIR__ . '/Generate/SecondTestDto.php');

        $this->assertTrue(
            class_exists(ExampleDto::class)
        );
        $this->assertTrue(
            class_exists(SecondTestDto::class)
        );


        $facade->deleteDataTransferObjects();

        $this->assertFileNotExists(__DIR__ . '/Generate/ExampleDto.php');
        $this->assertFileNotExists(__DIR__ . '/Generate/SecondTestDto.php');
    }

    public function testGenerateAndDeleteDtoWithOneConfig()
    {
        $config = new DataTransferTestConfig();
        $facade = $this->tester->createFacade(
            [
                DataTransferDomainDependencyProvider::DATA_TRANSFER_CONFIG_PLUGINS => [
                    new DataTransferTestConfig()
                ]
            ]
        );

        $facade->generateDataTransferObjectsByConfig($config);

        $this->assertFileExists(__DIR__ . '/Generate/ExampleDto.php');
        $this->assertFileExists(__DIR__ . '/Generate/SecondTestDto.php');

        $this->assertTrue(
            class_exists(ExampleDto::class)
        );
        $this->assertTrue(
            class_exists(SecondTestDto::class)
        );


        $facade->deleteDataTransferObjects();

        $this->assertFileNotExists(__DIR__ . '/Generate/ExampleDto.php');
        $this->assertFileNotExists(__DIR__ . '/Generate/SecondTestDto.php');
    }

    public function testDtoFunctionality()
    {
        $facade = $this->tester->createFacade(
            [
                DataTransferDomainDependencyProvider::DATA_TRANSFER_CONFIG_PLUGINS => [
                    new DataTransferTestConfig()
                ]
            ]
        );

        $facade->generateDataTransferObjects();

        $example = new ExampleDto();
        $example->setActive(true)
            ->setName('Test')
            ->setCompany(null)
            ->addLike('Soccer');

        $this->assertEquals(
            [
                'Soccer'
            ],
            $example->getLike()
        );

        $secondDto = new SecondTestDto();
        $secondDto->addEmployee($example);

        $this->assertEquals(
            [$example],
            $secondDto->getEmployees()
        );

        $this->assertEquals(
            [
                'Employees' => [
                    [
                        'Name' => 'Test',
                        'Active' => true,
                        'Company' => null,
                        'Like' => [
                            'Soccer'
                        ],
                    ]
                ]
            ],
            $secondDto->toArray()
        );

        $facade->deleteDataTransferObjects();
    }

    public function testRequired()
    {
        $facade = $this->tester->createFacade(
            [
                DataTransferDomainDependencyProvider::DATA_TRANSFER_CONFIG_PLUGINS => [
                    new DataTransferTestConfig()
                ]
            ]
        );

        $facade->generateDataTransferObjects();

        $example = new ExampleDto();
        $facade->deleteDataTransferObjects();

        $example->setName('Test');

        $this->expectException(RequiredPropertyNotDefinedException::class);
        $this->expectExceptionMessage('Required property Active is not defined');

        $example->requireName();
        $example->requireActive();
    }
}
