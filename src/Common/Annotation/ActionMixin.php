<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 6/11/14
 * Time: 1:12 PM
 */

namespace Arilas\KronaBundle\Common\Annotation;

use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionMethod;

/**
 * Class ActionMixin
 * @package Arilas\KronaBundle\Common\Annotation
 * @method \Zend\Mvc\Controller\Plugin\Redirect redirect()
 * @method \Zend\Http\Response                  notFoundAction()
 */
trait ActionMixin
{
    /** @var  AnnotationReader */
    protected $reader;

    /**
     * Method used for proceed AutoWired Binding
     *
     * @param ReflectionMethod $reflectionMethod
     * @return \Zend\Http\Response
     */
    public function checkMethod(ReflectionMethod $reflectionMethod)
    {
        $reader = $this->getAnnotationReader();
        $annotations = $reader->getMethodAnnotations($reflectionMethod);

        foreach ($annotations as $annotation) {
            if (method_exists($annotation, 'check')) {
                $annotation->check($this, $reflectionMethod);
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