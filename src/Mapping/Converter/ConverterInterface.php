<?php
/**
 * User: krona
 * Date: 6/11/14
 * Time: 7:20 AM
 */

namespace Arilas\KronaBundle\Mapping\Converter;


use Arilas\KronaBundle\Mapping\AnnotationInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

interface ConverterInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param AnnotationInterface     $annotation
     * @return mixed
     */
    public function convert(ServiceLocatorInterface $serviceLocator, AnnotationInterface $annotation);
} 