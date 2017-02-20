<?php

namespace AppBundle\Controller;

use AppBundle\Form\PatientType;
use AppBundle\Repository\HospitalRepository;
use AppBundle\Entity\Patient;
use AppBundle\Repository\RepositoryInterface;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PatientsController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return Response
     */
    public function getAction()
    {
        $view = $this->view(
            [
                'patients' => $this->getPatientRepository()->selectAll(),
                'msg' => 'Here are all patients',
            ]
        );
        $view->getSerializationContext()->setGroups(['default', 'patient']);

        return $this->handleView($view);
    }

    public function postAction(Request $request)
    {

        $patient = new Patient();

        $form = $this->createForm(new PatientType(), $patient);
        $form->submit((array)json_decode($request->getContent()));

        if (!$form->isValid()) {
            return $this->handleView($this->view($form));
        }


        $patient->setDoctor($this->getDoctorRepository()->selectById($patient->getDoctor()));
        $patient->setHospital($this->getHospitalRepository()->selectById($patient->getHospital()));
        $patient->setId(count($this->getPatientRepository()->selectAll()) + 1);

        $view = $this->view(
            [
                'patient' => $patient,
                'msg' => 'New patient for doctor ' . $patient->getDoctor()->getName(),
            ]
        );
        $view->getSerializationContext()->setGroups(['default', 'patient']);

        return $this->handleView($view);
    }

    /**
     * @return RepositoryInterface
     */
    private function getDoctorRepository()
    {
        return $this->get('doctor_repository');
    }

    /**
     * @return HospitalRepository
     */
    private function getPatientRepository()
    {
        return $this->get('patient_repository');
    }

    /**
     * @return RepositoryInterface
     */
    private function getHospitalRepository()
    {
        return $this->get('hospital_repository');
    }
}
