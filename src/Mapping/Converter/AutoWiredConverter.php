<?php
/**
 * User: krona
 * Date: 6/11/14
 * Time: 7:05 AM
 */

namespace Arilas\KronaBundle\Mapping\Converter;


use Arilas\KronaBundle\Mapping\AnnotationInterface;
use Arilas\KronaBundle\Mapping\Exception\ServiceNotFoundException;
use Zend\ServiceManager\ServiceLocatorInterface;

class AutoWiredConverter implements ConverterInterface
{
    /**
     * Method uses for fetching instance of some service that we need to be AutoWired
     * @param ServiceLocatorInterface                                                               $serviceLocator
     * @param \Arilas\KronaBundle\Mapping\AnnotationInterface|\Arilas\KronaBundle\Mapping\AutoWired $annotation
     * @throws \Arilas\KronaBundle\Mapping\Exception\ServiceNotFoundException
     * @return object
     */
    public function convert(ServiceLocatorInterface $serviceLocator, AnnotationInterface $annotation)
    {
        if (!is_null($annotation->getType())) {
            if ($serviceLocator->has($annotation->getType())) {
                return $serviceLocator->get($annotation->getType());
            } elseif (class_exists($annotation->getType())) {
                $className = $annotation->getType();
                return new $className($serviceLocator);
            } else {
                throw new ServiceNotFoundException(
                    'Service with name: ' . $annotation->getType() . ' was not found'
                );
            }
        }
    }
} 