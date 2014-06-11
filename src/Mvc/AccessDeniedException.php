<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 6/11/14
 * Time: 1:23 PM
 */

namespace Arilas\KronaBundle\Mvc;


use Arilas\KronaBundle\Exception\KronaException;

class AccessDeniedException extends KronaException
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