<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 6/11/14
 * Time: 1:52 PM
 */

namespace Arilas\KronaBundle\Mapping;

use Arilas\KronaBundle\Mvc\AccessDeniedException;
use Arilas\KronaBundle\Mvc\Controller\AbstractActionController;
use Doctrine\Common\Annotations\Annotation\Target;
use ReflectionMethod;

/**
 * Class Guest
 * @package Arilas\KronaBundle\Mapping
 * @Annotation
 * @Target("METHOD")
 */
class Guest implements AnnotationInterface
{
    public $redirect = null;

    public function check(AbstractActionController $controller, ReflectionMethod $reflectionMethod)
    {
        $identity = $controller->identity();
        if (!is_null($identity)) {
            $exception = new AccessDeniedException(
                'You must be guest to proceed to this action'
            );
            if (!is_null($this->redirect)) {
                $exception->setRedirect($this->redirect);
            }
            throw $exception;
        }
    }
} 