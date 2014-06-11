<?php
/**
 * User: krona
 * Date: 6/11/14
 * Time: 8:26 AM
 */

namespace Arilas\KronaBundle\Common\Annotation;


use Arilas\KronaBundle\Mapping\Converter\ConverterInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Trait AutoWiredMixin - uses for add AutoWired functionality to some class
 * @package Arilas\KronaBundle\Common
 */
trait PropertiesMixin
{
    /** @var  AnnotationReader */
    protected $reader;

    /**
     * Method used for proceed AutoWired Binding
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function processProperties(ServiceLocatorInterface $serviceLocator)
    {
        $reader = $this->getAnnotationReader();
        $reflectionClass = new ReflectionClass($this);

        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            $annotations = $reader->getPropertyAnnotations($reflectionProperty);

            foreach ($annotations as $annotation) {
                if (method_exists($annotation, 'getConverterClassName')) {
                    $converterClassName = $annotation->getConverterClassName();
                    /** @var ConverterInterface $converter */
                    $converter = new $converterClassName();
                    $reflectionProperty->setAccessible(true);
                    $reflectionProperty->setValue($this, $converter->convert($serviceLocator, $annotation));
                    $reflectionProperty->setAccessible(false);
                }
            }
        }
    }

    public function getAnnotationReader()
    {
        if (is_null($this->reader)) {
            $this->reader = new AnnotationReader();
        }

        return $this->reader;
    }
} 