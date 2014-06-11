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

/**
 * Class AbstractActionController
 * @package Arilas\KronaBundle\Mvc\Controller
 */
class AbstractActionController extends BaseController implements FactoryInterface
{
    use AutoWiredMixin;

    /**
     * Method uses for building Controller with initialize all dependencies
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return $this
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $this->processAutoWire($serviceLocator);

        return $this;
    }

    /**
     * Method is a synonym of getServiceLocator()->get()
     *
     * @param $serviceName
     * @return array|object
     */
    public function get($serviceName)
    {
        return $this->getServiceLocator()->get($serviceName);
    }

    /**
     * Method is a synonym of getServiceLocator()->has()
     *
     * @param $serviceName
     * @return bool
     */
    public function has($serviceName)
    {
        return $this->getServiceLocator()->has($serviceName);
    }
}