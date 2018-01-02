<?php
namespace Phil\MoneyBundle\DependencyInjection\Compiler;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class StorageCompilerPass
 * @package Phil\MoneyBundle\DependencyInjection\Compiler
 */
class StorageCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        $storage = $container->getParameter('phil_money.pair.storage');

        //Determine if DoctrineBundle is defined
        if ('doctrine' === $storage) {
            if (!isset($bundles['DoctrineBundle'])) {
                throw new \RuntimeException('PhilMoneyBundle - DoctrineBundle is needed to use Doctrine as a storage');
            }

            //Add doctrine schema mappings
            $modelDir = realpath(__DIR__.'/../../Resources/config/doctrine/ratios');
            $path = DoctrineOrmMappingsPass::createXmlMappingDriver(array(
                $modelDir => 'Phil\MoneyBundle\Entity',
            ));
            $path->process($container);

            $storageDoctrineDefinition = new Definition('Phil\MoneyBundle\Pair\Storage\DoctrineStorage', array(
                new Reference('doctrine.orm.entity_manager'),
                $container->getParameter('phil_money.reference_currency'),
            ));

            $container->setDefinition('phil_money.pair.doctrine_storage', $storageDoctrineDefinition);
            $container->getDefinition('phil_money.pair_manager')->replaceArgument(0, new Reference('phil_money.pair.doctrine_storage'));
        }
    }
}
