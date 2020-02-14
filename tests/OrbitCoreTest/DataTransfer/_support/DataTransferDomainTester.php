<?php
namespace OrbitCoreTest\DataTransfer;

use Codeception\Stub;
use OrbitCore\DataTransfer\DataTransferConfig;
use OrbitCore\DataTransfer\Domain\DataTransferDomainDependencyProvider;
use OrbitCore\DataTransfer\Domain\DataTransferDomainFactory;
use OrbitCore\DataTransfer\Domain\DataTransferFacade;
use OrbitCore\Infrastructure\Container\ContainerInterface;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class DataTransferDomainTester extends \Codeception\Actor
{
    use _generated\DataTransferDomainTesterActions;

   /**
    * Define custom actions here
    */
    public function createFacade(array $dependencies = [])
    {
        $factory = $this->createFactory($dependencies);

        $facade = new DataTransferFacade();
        $facade->setResolver(
            $this->createResolver(
                null,
                null,
                $factory
            )
        );

        return $facade;
    }

    /**
     * @param array $dependencies
     *
     * @return \OrbitCore\DataTransfer\Domain\DataTransferDomainFactory
     * @throws \Exception
     */
    public function createFactory(array $dependencies = [])
    {
        $config = Stub::make(
            DataTransferConfig::class,
            [
                'get' => function() {
                    return 'test';
                }
            ]
        );

        $factory = new DataTransferDomainFactory();
        $factory->setResolver(
            $this->createResolver(
                $config,
                new DataTransferDomainDependencyProvider(),
                null
            )
        );

        /** @var \OrbitCore\Infrastructure\Container\ContainerInterface $container */
        $container = Stub::makeEmpty(
            ContainerInterface::class,
            [
                'get' => function ($name) use ($dependencies) {
                    return $dependencies[$name] ?? null;
                }
            ]
        );


        $factory->setDependencyContainer($container);

        return $factory;
    }
}
