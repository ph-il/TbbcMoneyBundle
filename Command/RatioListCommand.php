<?php
namespace Phil\MoneyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Phil\MoneyBundle\Pair\PairManagerInterface;

/**
 * Class RatioListCommand
 * @package Tbbc\MoneyBundle\Command
 */
class RatioListCommand extends ContainerAwareCommand
{
    /**
     * Configure command
     */
    protected function configure()
    {
        $this
            ->setName('phil:money:ratio-list')
            ->setHelp('The <info>phil:money:ratio-list</info> display list of registered ratio')
            ->setDescription('display list of registered ratio')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var PairManagerInterface $pairManager */
        $pairManager = $this->getContainer()->get('phil_money.pair_manager');
        $ratioList = $pairManager->getRatioList();
        $output->writeln('Ratio list');
        foreach ($ratioList as $currencyCode => $ratio) {
            $output->writeln($currencyCode.';'.$ratio);
        }
    }
}
