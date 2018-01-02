<?php
namespace Phil\MoneyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Phil\MoneyBundle\MoneyException;
use Phil\MoneyBundle\Pair\PairManagerInterface;

/**
 * Class RatioSaveCommand
 * @package Phil\MoneyBundle\Command
 */
class RatioSaveCommand extends ContainerAwareCommand
{
    /**
     * Configure command
     */
    protected function configure()
    {
        $this
            ->setName('phil:money:ratio-save')
            ->setHelp('The <info>phil:money:ratio-save</info> save a currency ratio')
            ->setDescription('save a currency ratio')
            ->addArgument(
                'currencyCode',
                InputArgument::REQUIRED,
                'Currency (Ex: EUR|USD|...) ?'
            )
            ->addArgument(
                'ratio',
                InputArgument::REQUIRED,
                'Ratio to the reference currency (ex: 1.2563) ?'
            )
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
        $currencyCode = $input->getArgument('currencyCode');
        $ratio = (float) $input->getArgument('ratio');

        /** @var PairManagerInterface $pairManager */
        $pairManager = $this->getContainer()->get('phil_money.pair_manager');
        try {
            $pairManager->saveRatio($currencyCode, $ratio);
            $output->writeln('ratio saved');
        } catch (MoneyException $e) {
            $output->writeln('ERROR : ratio no saved du to error : '.$e->getMessage());
        }
    }
}
