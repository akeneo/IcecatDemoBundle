Akeneo PIM Icecat Demo Bundle
=============================

This bundle contains real world data coming from the Icecat databases.

To install the demo data, use the following commands :

WARNING: the contents of your database will be replaced

Installing the bundle
---------------------
From your application root:

    $ php composer.phar require --prefer-dist "akeneo/icecat-demo-bundle=dev-master"

Add the following line inside the `app/AppKernel.php` file:

    new Pim\\Bundle\\IcecatDemoBundle\\PimIcecatDemoBundle(),

Define the data used by the installer in the parameters.yml file:

    installer_data: 'PimIcecatDemoBundle:icecat_demo'

Loading the data
----------------
    ./install.sh db
    php app/console doctrine:fixtures:load --append --fixtures=vendor/akeneo/icecat-demo-bundle/Pim/Bundle/IcecatDemoBundle/DataFixtures/
    php app/console cache:clear --env=prod
    php app/console pim:icecat-demo:import --env=prod
    php app/console pim:completeness:calculate --env=prod
    php app/console pim:versioning:refresh --env=prod

Icecat data
-----------
For more information about Icecat, please see http://icecat.biz/
