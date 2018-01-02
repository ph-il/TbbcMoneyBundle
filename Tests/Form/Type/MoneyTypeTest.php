<?php
/**
 * Created by Philippe Le Van.
 * Date: 01/07/13
 */

namespace Phil\MoneyBundle\Tests\Form\Type;

use Money\Currency;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\FormIntegrationTestCase;
use Phil\MoneyBundle\Form\Type\CurrencyType;
use Phil\MoneyBundle\Form\Type\MoneyType;
use Symfony\Component\Form\Test\TypeTestCase;
use Money\Money;

class MoneyTypeTest
    extends TypeTestCase
{

    private $currencyTypeClass = 'Phil\MoneyBundle\Form\Type\CurrencyType';
    private $moneyTypeClass = 'Phil\MoneyBundle\Form\Type\MoneyType';

    public function testBindValid()
    {
        $form = $this->factory->create($this->moneyTypeClass, null, array(
            "currency_type" => $this->currencyTypeClass,
        ));
        $form->submit(array(
            "phil_currency" => array("phil_name"=>'EUR'),
            "phil_amount" => '12'
        ));
        $this->assertEquals(Money::EUR(1200), $form->getData());
    }

    public function testBindDecimalValid()
    {
        \Locale::setDefault("fr_FR");
        $form = $this->factory->create($this->moneyTypeClass, null, array(
            "currency_type" => $this->currencyTypeClass,
        ));
        $form->submit(array(
            "phil_currency" => array("phil_name"=>'EUR'),
            "phil_amount" => '12,5'
        ));
        $this->assertEquals(Money::EUR(1250), $form->getData());
    }

    public function testGreaterThan1000Valid()
    {
        \Locale::setDefault("fr_FR");
        $form = $this->factory->create($this->moneyTypeClass, null, array(
            "currency_type" => $this->currencyTypeClass,
        ));
        $form->submit(array(
            "phil_currency" => array("phil_name"=>'EUR'),
            "phil_amount" => '1 252,5'
        ));
        $this->assertEquals(Money::EUR(125250), $form->getData());
    }

    public function testSetData()
    {
        \Locale::setDefault("fr_FR");
        $form = $this->factory->create($this->moneyTypeClass, null, array(
            "currency_type" => $this->currencyTypeClass,
        ));
        $form->setData(Money::EUR(120));
        $formView = $form->createView();

        $this->assertEquals("1,20", $formView->children["phil_amount"]->vars["value"]);
    }

    protected function getExtensions()
    {
        return array(
            new PreloadedExtension(
                array(new CurrencyType(array("EUR", "USD"), "EUR"), new MoneyType(2)), array()
            )
        );
    }

}