<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Doctor;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Response;

class DoctorController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @param Doctor $doctor
     *
     * @return Response
     */
    public function getPatientsAction(Doctor $doctor)
    {
        $view = $this->view(
            [
                'doctor' => $doctor,
                'msg' => 'Here are the patients for ' . $doctor->getName(),
            ]
        );
        $view->getSerializationContext()->setGroups(['default', 'doctor']);

        return $this->handleView($view);
    }
}
