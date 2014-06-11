<?php
/**
 * User: krona
 * Date: 6/11/14
 * Time: 8:26 AM
 */

namespace Arilas\KronaBundle\Common;


use Arilas\KronaBundle\Mapping\Converter\ConverterInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;
use Zend\ServiceManager\ServiceLocatorInterface;

trait AutoWiredMixin
{
    /** @var  AnnotationReader */
    protected $reader;

    /**
     *
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function processAutoWire(ServiceLocatorInterface $serviceLocator)
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
                    try {
                        $reflectionProperty->setValue($this, $converter->convert($serviceLocator, $annotation));
                    } catch (\Exception $e) {
                        var_dump($e->getMessage());
                        exit;
                    }
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