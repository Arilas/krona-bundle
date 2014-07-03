<?php
/**
 * User: krona
 * Date: 6/11/14
 * Time: 6:29 AM
 */

namespace Arilas\KronaBundle\Mvc\Controller;

use Arilas\KronaBundle\Common\Annotation\ActionMixin;
use Arilas\KronaBundle\Common\Annotation\PropertiesMixin;
use Arilas\KronaBundle\Mvc\AccessDeniedException;
use Arilas\KronaBundle\Mvc\Exception\NotFoundException;
use Zend\Mvc\Controller\AbstractActionController as BaseController;
use Zend\Mvc\Exception\DomainException;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AbstractActionController
 * @package Arilas\KronaBundle\Mvc\Controller
 */
class AbstractActionController extends BaseController implements FactoryInterface
{
    use PropertiesMixin;
    use ActionMixin;

    /**
     * Method uses for building Controller with initialize all dependencies
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return $this
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $this->processProperties($serviceLocator);

        return $this;
    }

    public function onDispatch(MvcEvent $event)
    {
        $routeMatch = $event->getRouteMatch();
        if (!$routeMatch) {
            throw new DomainException('Missing route matches; unsure how to retrieve action');
        }

        $methods = $routeMatch->getParam('methods', []);
        if (!empty($methods) && $methods[$this->getRequest()->getMethod()]) {
            $routeMatch->setParam('action', $methods[$this->getRequest()->getMethod()]);
        }

        $action = $routeMatch->getParam('action', 'not-found');
        $method = static::getMethodFromAction($action);

        $methodReflection = new \ReflectionMethod($this, $method);
        try {
            $this->checkMethod($methodReflection);
        } catch (NotFoundException $e) {
            if (!is_null($e->getRedirect())) {
                return $this->redirect()->toRoute($e->getRedirect());
            } else {
                return $this->notFoundAction();
            }
        } catch (AccessDeniedException $e) {
            if (!is_null($e->getRedirect())) {
                return $this->redirect()->toRoute($e->getRedirect());
            } else {
                return $this->notFoundAction();
            }
        }

        return parent::onDispatch($event);
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