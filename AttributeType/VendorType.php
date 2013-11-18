<?php
namespace Pim\Bundle\IcecatDemoBundle\AttributeType;

use Oro\Bundle\FlexibleEntityBundle\Model\AbstractAttribute;
use Oro\Bundle\FlexibleEntityBundle\AttributeType\AbstractAttributeType;
use Oro\Bundle\FlexibleEntityBundle\Model\FlexibleValueInterface;

/**
 * Vendor attribute type
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/MIT MIT
 */
class VendorType extends AbstractAttributeType
{
    /**
     * {@inheritdoc}
     */
    protected function prepareValueFormOptions(FlexibleValueInterface $value)
    {
        $options = parent::prepareValueFormOptions($value);
        $options['class']    = 'Pim\Bundle\IcecatDemoBundle\Entity\Vendor';

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    protected function defineCustomAttributeProperties(AbstractAttribute $attribute)
    {
        $properties = array();

        return $properties;
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pim_icecatdemo_vendor';
    }
}
