<?php
namespace Phil\MoneyBundle\Templating\Helper;

use Money\Currency;
use Symfony\Component\Templating\Helper\Helper;
use Phil\MoneyBundle\Formatter\MoneyFormatter;

/**
 * Class CurrencyHelper
 * @package Phil\MoneyBundle\Templating\Helper
 */
class CurrencyHelper extends Helper
{
    /**
     * @var MoneyFormatter
     */
    protected $moneyFormatter;

    /**
     * Constructor
     *
     * @param MoneyFormatter $moneyFormatter
     */
    public function __construct(MoneyFormatter $moneyFormatter)
    {
        $this->moneyFormatter = $moneyFormatter;
    }

    /**
     * Returns the name as string of the given currency
     *
     * @param Currency $currency
     * @return string
     */
    public function name(Currency $currency)
    {
        return $this->moneyFormatter->formatCurrencyAsName($currency);
    }

    /**
     * Returns the symbol corresponding to the given currency
     *
     * @param Currency $currency
     * @return string
     */
    public function symbol(Currency $currency)
    {
        return $this->moneyFormatter->formatCurrencyAsSymbol($currency);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'phil_money_currency_helper';
    }
}
