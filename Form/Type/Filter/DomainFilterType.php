<?php

namespace Pim\Bundle\IcecatDemoBundle\Form\Type\Filter;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityManager;

/**
 * Vendor filter type
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
class VendorFilterType extends AbstractType
{
    /**
     * @staticvar string
     */
    const NAME = 'pim_icecatdemo_vendor';

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param TranslatorInterface $translator
     * @param ChannelManager      $channelManager
     */
    public function __construct(TranslatorInterface $translator, EntityManager $entityManager)
    {
        parent::__construct($translator);

        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return ChoiceFilterType::NAME;
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $vendors = $this->entityManager->getRepository('PimIcecatDemoBundle:Vendor')->findAll();
        $vendorChoices = array();
        foreach ($vendors as $vendor) {
            $vendorChoices[$vendor->getId()]= $vendor->getLabel();
        }
        asort($vendorChoices);

        $choices = array(
            self::TYPE_CONTAINS => $this->translator->trans('label_type_contains', array(), 'OroFilterBundle'),
            self::TYPE_NOT_CONTAINS => $this->translator->trans('label_type_not_contains', array(), 'OroFilterBundle'),
        );

        $resolver->setDefaults(
            array(
                'field_type' => 'choice',
                'field_options' => array('choices' => $vendorChoices),
                'operator_choices' => $choices,
            )
        );
    }
}
