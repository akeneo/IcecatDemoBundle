<?php

namespace Pim\Bundle\IcecatDemoBundle\Datagrid;

use Oro\Bundle\GridBundle\Field\FieldDescriptionInterface;
use Pim\Bundle\CatalogBundle\Datagrid\GroupProductDatagridManager as PimGroupProductDatagridManager;

/**
 * Override of the group datagrid manager to add the vendor column
 *
 * @author    Benoit Jacquemont <benoit@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class GroupProductDatagridManager extends PimGroupProductDatagridManager
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $typeMatches = array(
            'vendor' => array(
                'field'  => FieldDescriptionInterface::TYPE_TEXT,
                'filter' => 'pim_icecatdemo_orm_vendor'
            )
        );

        static::$typeMatches = array_merge(static::$typeMatches, $typeMatches);
    }
}
