<?php

namespace Pim\Bundle\IcecatDemoBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Replaces the mapping for ProductValueInterfdace
 * 
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DoctrineConfigurationPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $container->findDefinition('doctrine.orm.listeners.resolve_target_entity')
            ->addMethodCall(
                'addResolveTargetEntity',
                array(
                    'Pim\Bundle\CatalogBundle\Model\ProductValueInterface',
                    'Pim\Bundle\IcecatDemoBundle\Entity\ProductValue',
                    array()
                )
            );
    }
}
