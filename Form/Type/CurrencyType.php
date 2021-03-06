<?php

namespace Phil\MoneyBundle\Form\Type;

use Phil\MoneyBundle\Form\DataTransformer\CurrencyToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form type for the Currency object.
 */
class CurrencyType extends AbstractType
{
    /** @var  array of string (currency code like "USD", "EUR") */
    protected $currencyCodeList;
    /** @var  string (currency code like "USD", "EUR") */
    protected $referenceCurrencyCode;

    /**
     * CurrencyType constructor.
     *
     * @param array  $currencyCodeList
     * @param string $referenceCurrencyCode
     */
    public function __construct($currencyCodeList, $referenceCurrencyCode)
    {
        $this->currencyCodeList = $currencyCodeList;
        $this->referenceCurrencyCode = $referenceCurrencyCode;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choiceList = array();
        foreach ($options["currency_choices"] as $currencyCode) {
            $choiceList[$currencyCode] = $currencyCode;
        }
        $builder->add('phil_name', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            "choices" => $choiceList,
            "preferred_choices" => array($options["reference_currency"]),
        ));
        $builder->addModelTransformer(new CurrencyToArrayTransformer());
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(array('reference_currency', 'currency_choices'));
        $resolver->setDefaults(array(
            'reference_currency' => $this->referenceCurrencyCode,
            'currency_choices' => $this->currencyCodeList,
        ));
        $resolver->setAllowedTypes('reference_currency', 'string');
        $resolver->setAllowedTypes('currency_choices', 'array');
        $resolver->setAllowedValues('reference_currency', $this->currencyCodeList);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'phil_currency';
    }
}
