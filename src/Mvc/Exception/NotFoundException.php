<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 6/11/14
 * Time: 1:22 PM
 */

namespace Arilas\KronaBundle\Mvc\Exception;


use Arilas\KronaBundle\Exception\KronaException;

class NotFoundException extends KronaException
{
    protected $redirect;

    public function getRedirect()
    {
        return $this->redirect;
    }

    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }
} 