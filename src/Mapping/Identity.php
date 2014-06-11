<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 6/11/14
 * Time: 1:14 PM
 */

namespace Arilas\KronaBundle\Mapping;

use Arilas\KronaBundle\Mvc\AccessDeniedException;
use Arilas\KronaBundle\Mvc\Controller\AbstractActionController;
use Doctrine\Common\Annotations\Annotation\Target;
use ReflectionMethod;

/**
 * Class Identity
 * @package Arilas\KronaBundle\Mapping
 * @Annotation
 * @Target("METHOD")
 */
class Identity implements AnnotationInterface
{
    protected $criteria;

    protected $redirect;

    public function __construct($value)
    {
        if (is_array($value)) {
            $this->criteria = (isset($value['value'])) ? $value['value'] : [];
            $this->redirect = (isset($value['redirect'])) ? $value['redirect'] : null;
        }
    }

    public function check(AbstractActionController $controller, ReflectionMethod $reflectionMethod)
    {
        $identity = $controller->identity();
        if (is_null($identity)) {
            $exception = new AccessDeniedException(
                'You must be authenticated to proceed to this action'
            );
            if (!is_null($this->redirect)) {
                $exception->setRedirect($this->redirect);
            }
            throw $exception;
        }

        if (is_object($identity)) {
            $result = true;
            foreach ($this->criteria as $key => $value) {
                if (!$result) {
                    break;
                }
                if (is_array($value)) {
                    $method = 'get' . ucfirst($key);
                    if (method_exists($identity, $method)) {
                        $result = in_array($identity->$method(), $value);
                    }
                } else {
                    $method = 'get' . ucfirst($key);
                    if (method_exists($identity, $method)) {
                        $result = ($identity->$method() == $value);
                    }
                }
            }

            if (!$result) {
                $exception = new AccessDeniedException();
                if (!is_null($this->redirect)) {
                    $exception->setRedirect($this->redirect);
                }

                throw $exception;
            }

            return $result;
        } else {
            //TODO: implement this
        }
    }
} 