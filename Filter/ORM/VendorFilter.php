<?php

namespace Pim\Bundle\IcecatDemoBundle\Filter\ORM;

use Pim\Bundle\IcecatDemoBundle\Form\Type\Filter\VendorFilterType;
use Oro\Bundle\GridBundle\Filter\ORM\ChoiceFilter;

/**
 * Overriding of Choice filter
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class VendorFilter extends ChoiceFilter
{

    /**
     * Override apply method to disable filtering apply in query
     *
     * {@inheritdoc}
     */
    public function apply($queryBuilder, $value)
    {
        if (isset($value['value'])) {
            $alias = current($queryBuilder->getRootAliases());
            $queryBuilder
                ->innerJoin($alias.'.values', 'FilterVendorValue', 'WITH', 'FilterVendorValue.vendor IN (:vendor)')
                ->setParameter('vendor', $value['value']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions()
    {
        return array(
            'form_type' => VendorFilterType::NAME
        );
    }

    /**
     * {@inheritdoc}
     */
    public function parseData($data)
    {
        return false;
    }
}
