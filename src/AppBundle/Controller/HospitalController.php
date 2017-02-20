<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Hospital;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Response;

class HospitalController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @param Hospital $hospital
     *
     * @return Response
     */
    public function getPatientsAction(Hospital $hospital)
    {
        $view = $this->view(
            [
                'hospital' => $hospital,
                'msg' => 'Here are the patients for ' . $hospital->getName(),
            ]
        );
        $view->getSerializationContext()->setGroups(['default', 'hospital']);

        return $this->handleView($view);
    }
}
