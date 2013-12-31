<?php

namespace Pim\Bundle\IcecatDemoBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;

class PimIcecatDemoBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $productMappings = array(
            realpath(__DIR__ . '/Resources/config/model/doctrine') => 'Pim\Bundle\IcecatDemoBundle\Model'
        );

        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createYamlMappingDriver(
                $productMappings,
                array('doctrine.orm.entity_manager'),
                'pim_catalog.storage_driver.doctrine/orm'
            )
        );
    }
}
