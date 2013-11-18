<?php

namespace Pim\Bundle\IcecatDemoBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PimIcecatDemoBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $collection = $this->container
            ->get('routing.loader')
            ->load(__DIR__.'/Resources/config/routing.yml');
 
        $this->container
            ->get('router')
            ->getRouteCollection()
            ->addCollection($collection);
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container
            ->addCompilerPass(new DependencyInjection\Compiler\DoctrineConfigurationPass())
            ->addCompilerPass(new DependencyInjection\Compiler\AttributeTypesPass());
    }
}
