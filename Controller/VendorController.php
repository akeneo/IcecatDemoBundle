<?php

namespace Pim\Bundle\IcecatDemoBundle\Controller;

use Pim\Bundle\IcecatDemoBundle\Entity\Vendor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Vendor controller
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @Route("/vendor")
 */
class VendorController extends Controller
{

    /**
     * List Vendor entities
     *
     * @param Request $request
     *
     * @Route(
     *     "/.{_format}",
     *     requirements={"_format" = "html|json"},
     *     defaults={"_format" = "html"}
     * )
     * @Template()
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        /** @var $queryBuilder QueryBuilder */
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->select('c')
            ->from('PimIcecatDemoBundle:Vendor', 'c');

        /** @var $queryFactory QueryFactory */
        $queryFactory = $this->get('pim_icecat_demo.datagrid.manager.vendor.default_query_factory');
        $queryFactory->setQueryBuilder($queryBuilder);

        /** @var $datagridManager VendorDatagridManager */
        $datagridManager = $this->get('pim_icecat_demo.datagrid.manager.vendor');
        $datagrid = $datagridManager->getDatagrid();

        $view = ('json' === $request->getRequestFormat()) ?
            'OroGridBundle:Datagrid:list.json.php' : 'PimIcecatDemoBundle:Vendor:index.html.twig';

        return $this->render($view, array('datagrid' => $datagrid->createView()));
    }

    /**
     * Create Vendor using simple form
     *
     * @Route("/quickcreate")
     * @Template("PimIcecatDemoBundle:Vendor:quickcreate.html.twig")
     *
     * @return array
     */
    public function quickCreateAction()
    {
        $vendor = new Vendor();

        $form = $this->createForm('pim_icecatdemo_vendor', $vendor);
        $form->setData($vendor);

        if ($this->getRequest()->getMethod() === 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $this->getDoctrine()->getEntityManager()->persist($vendor);
                $this->getDoctrine()->getEntityManager()->flush();

                $this->get('session')->getFlashBag()->add('success', 'Vendor successfully saved');

                $url = $this->generateUrl('pim_icecatdemo_vendor_index');

                $response = array('status' => 1, 'url' => $url);

                return new Response(json_encode($response));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * Edit vendor
     *
     * @param Vendor $vendor the vendor to edit
     *
     * @Route(
     *     "/edit/{id}",
     *     requirements={"id"="\d+"},
     *     defaults={"id"=0}
     * )
     * @Template("PimIcecatDemoBundle:Vendor:edit.html.twig")
     *
     * @return array
     */
    public function editAction(Vendor $vendor)
    {
        $request = $this->getRequest();
        $form = $this->createForm('pim_icecatdemo_vendor', $vendor);

        if ($request->getMethod() === 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($vendor);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'Vendor successfully saved');

                return $this->redirect($this->generateUrl('pim_icecatdemo_vendor_index'));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * Remove vendor
     *
     * @param Vendor $vendor
     *
     * @Route("/remove/{id}", requirements={"id"="\d+"})
     * @Method({"post","delete"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(Vendor $vendor)
    {
        $this->getEntityManager()->remove($vendor);
        $this->getEntityManager()->flush();
        return new Response('', 204);
    }

    /**
     * Get entity manager
     *
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getEntityManager();
    }
}
