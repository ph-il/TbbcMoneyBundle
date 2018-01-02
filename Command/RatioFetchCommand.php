<?php
namespace Phil\MoneyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Phil\MoneyBundle\MoneyException;
use Phil\MoneyBundle\Pair\PairManagerInterface;

/**Phil
 * Class RatioFetchCommand
 * @package Phil\MoneyBundle\Command
 */
class RatioFetchCommand extends ContainerAwareCommand
{
    /**
     * Configure command
     */
    protected function configure()
    {
        $this
            ->setName('phil:money:ratio-fetch')
            ->setHelp('The <info>phil:money:ratio-fetch</info> fetch all needed ratio from a external ratio provider')
            ->setDescription('fetch all needed ratio from a external ratio provider')
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
        try {
            $pairManager->saveRatioListFromRatioProvider();
            $output->writeln('ratio fetched from provider'.PHP_EOL.print_r($pairManager->getRatioList(), true));
        } catch (MoneyException $e) {
            $output->writeln('ERROR during fetch ratio : '.$e->getMessage());
        }
    }
}
