<?php

namespace Pim\Bundle\IcecatDemoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Pim\Bundle\IcecatDemoBundle\Entity\Vendor;

/**
 * Vendor Fixtures
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class LoadVendors implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $f = fopen(sprintf('%s/vendors.csv', $this->getImportDir()), 'r');
        $labels = fgetcsv($f, 0, ';');
        while ($values = fgetcsv($f, 0, ';')) {
            $data = array_combine($labels, $values);
            $vendor = new Vendor;
            $vendor->setCode($data['code'])->setLabel($data['label']);
            $manager->persist($vendor);
        }

        fclose($f);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Get import dir
     */
    protected function getImportDir()
    {
        return $this->container->getParameter('pim_icecatdemo.import_dir');
    }
}
