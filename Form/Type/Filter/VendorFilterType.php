<?php

namespace Pim\Bundle\IcecatDemoBundle\Form\Type\Filter;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use Oro\Bundle\FilterBundle\Form\Type\Filter\ChoiceFilterType;
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
    const NAME = 'pim_icecatdemo_filter_vendor';

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param TranslatorInterface $translator
     * @param ChannelManager      $channelManager
     */
    public function __construct(TranslatorInterface $translator, EntityManager $entityManager)
    {
        $this->translator = $translator;
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
        $vendors = $this->entityManager->getRepository('PimIcecatDemoBundle:Vendor')->findBy(
            array(),
            array('label' => 'asc')
        );
        $vendorChoices = array();
        foreach ($vendors as $vendor) {
            $vendorChoices[$vendor->getId()]= $vendor->getLabel();
        }
        $choices = array(
            ChoiceFilterType::TYPE_CONTAINS => $this->translator->trans('label_type_contains', array(), 'OroFilterBundle'),
            ChoiceFilterType::TYPE_NOT_CONTAINS => $this->translator->trans('label_type_not_contains', array(), 'OroFilterBundle'),
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
