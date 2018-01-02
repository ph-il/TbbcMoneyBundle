<?php
namespace Phil\MoneyBundle\Tests\Console;

use Phil\MoneyBundle\Pair\PairManagerInterface;
use Phil\MoneyBundle\Tests\TestUtil\CommandTestCase;

/**
 * @group functionnal
 */
class ConsoleTest
    extends CommandTestCase
{
    /** @var  \Symfony\Bundle\FrameworkBundle\Client */
    private $client;
    public function setUp()
    {
        parent::setUp();
        /** @var \Symfony\Bundle\FrameworkBundle\Client client */
        $this->client = static::createClient();

        $this->runCommand($this->client,'doctrine:database:create');
        $this->runCommand($this->client,'doctrine:schema:update --force');
    }

    public function testRunSaveRatio()
    {
        $client = $this->client;


        $output = $this->runCommand($client, "phil:money:ratio-save USD 1.265");

        /** @var PairManagerInterface $pairManager */
        $pairManager = $client->getContainer()->get("phil_money.pair_manager");
        $this->assertEquals(1.265, $pairManager->getRelativeRatio("EUR", "USD"));
    }
    public function testRunRatioList()
    {
        $client = $this->client;
        $output = $this->runCommand($client, "phil:money:ratio-save USD 1.265");
        $output = $this->runCommand($client, "phil:money:ratio-save CAD 1.1");

        $output = $this->runCommand($client, "phil:money:ratio-list");

        $this->assertEquals("Ratio list\nEUR;1\nUSD;1.265\nCAD;1.1\n\n", $output);
    }

    public function testRunRatioFetch()
    {
        $client = $this->client;
        $output = $this->runCommand($client, "phil:money:ratio-fetch");
        $this->assertNotContains("ERR", $output);

        $output = $this->runCommand($client, "phil:money:ratio-list");

        $this->assertRegExp("/^Ratio list\nEUR;1\nUSD;\d.\d+\nCAD;\d.\d+\n\n$/", $output);
    }
}
