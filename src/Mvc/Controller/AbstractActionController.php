<?php
/**
 * User: krona
 * Date: 6/11/14
 * Time: 6:29 AM
 */

namespace Arilas\KronaBundle\Mvc\Controller;

use Arilas\KronaBundle\Common\AutoWiredMixin;
use Zend\Mvc\Controller\AbstractActionController as BaseController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractActionController extends BaseController implements FactoryInterface
{
    use AutoWiredMixin;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $this->processAutoWire($serviceLocator);

        return $this;
    }
}