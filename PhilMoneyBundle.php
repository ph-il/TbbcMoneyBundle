<?php
namespace Phil\MoneyBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Phil\MoneyBundle\DependencyInjection\Compiler\PairHistoryCompilerPass;
use Phil\MoneyBundle\DependencyInjection\Compiler\RatioProviderCompilerPass;
use Phil\MoneyBundle\DependencyInjection\Compiler\StorageCompilerPass;
use Phil\MoneyBundle\DependencyInjection\Compiler\DoctrineTypeCompilerPass;

/**
 * Class PhilMoneyBundle
 * @package Phil\MoneyBundle
 */
class PhilMoneyBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new StorageCompilerPass());
        $container->addCompilerPass(new PairHistoryCompilerPass());
        $container->addCompilerPass(new RatioProviderCompilerPass());
    }
}
