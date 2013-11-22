<?php

namespace Pim\Bundle\IcecatDemoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Bridge\Doctrine\Tests\Fixtures\ContainerAwareFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Oro\Bundle\BatchBundle\Entity\JobInstance;

/**
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class LoadImportProfiles extends ContainerAwareFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $importDir = $this->container->getParameter('pim_icecatdemo.import_dir');
        $this->loadJobInstance(
            $manager,
            'category_import',
            'initial_category_import',
            'Initial category import',
            sprintf('%s/%s', $importDir, 'categories.csv')
        );
        $productFiles = glob(sprintf('%s/products/*.csv', $importDir));
        foreach ($productFiles as $file) {
            $jobInstanceCode = basename($file, '.csv');
            $this->loadJobInstance(
                $manager,
                'product_import',
                sprintf('initial_product_import_%s', $jobInstanceCode),
                sprintf('Initial product import %s', $jobInstanceCode),
                $file
            );
        }
        $manager->flush();
    }
    protected function loadJobInstance(ObjectManager $manager, $alias, $code, $label, $file, $channel = null)
    {
        $jobInstance = new JobInstance('Akeneo CSV Connector', 'import', $alias);
        $connectorRegistry = $this->container->get('oro_batch.connectors');
        $job = $connectorRegistry->getJob($jobInstance);
        foreach($job->getSteps() as $step) {
            $step->getReader()->setFilePath($file);
        }
        $jobInstance
            ->setCode($code)
            ->setLabel($label)
            ->setJob($job);
        $manager->persist($jobInstance);

    }
}
