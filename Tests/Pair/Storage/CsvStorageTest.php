<?php
namespace Phil\MoneyBundle\Tests\Pair\Storage;

use Money\Money;
use Phil\MoneyBundle\MoneyException;
use Phil\MoneyBundle\Pair\PairManager;
use Phil\MoneyBundle\Pair\PairManagerInterface;
use Phil\MoneyBundle\Pair\Storage\CsvStorage;

/**
 * @group manager
 */
class CsvStorageTest extends \PHPUnit_Framework_TestCase
{
    /** @var  CsvStorage */
    protected $storage;
    protected $fileName;
    public function setUp()
    {
        $this->fileName = __DIR__."/../app/data/phil_money/pair.csv";
        $dir = dirname($this->fileName);
        exec("rm -rf ".escapeshellarg($dir));
        $this->storage = new CsvStorage($this->fileName, "EUR");
    }

    public function tearDown()
    {
        $dir = dirname($this->fileName);
        exec("rm -rf ".escapeshellarg($dir));
    }

    public function testSave()
    {
        $ratioList = $this->storage->loadRatioList();
        $this->assertEquals(
            "EUR;1\n",
            file_get_contents($this->fileName)
        );
        $ratioList["USD"] = 1.25;
        $this->storage->saveRatioList($ratioList);
        $this->assertEquals(
            "EUR;1\nUSD;1.25\n",
            file_get_contents($this->fileName)
        );

        $ratioList = $this->storage->loadRatioList();
        $this->assertEquals(array("EUR"=>1.0, "USD"=>1.25), $ratioList);

        $this->storage->saveRatioList($ratioList);
        $this->assertEquals(
            "EUR;1\nUSD;1.25\n",
            file_get_contents($this->fileName)
        );

    }
}