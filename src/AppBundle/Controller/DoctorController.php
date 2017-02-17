<?php

namespace AppBundle\Controller;

use AppBundle\Repository\PatientRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Repository\DoctorRepository;

class DoctorController extends Controller
{
    /** @var array */
    protected $data;

    /**
     * @Route(
     *     "/showdoctorpatients/{doctorId}",
     *     name="get_doctor_patients",
     *     requirements={"doctorId": "\d+"}
     * )
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getPatientsAction(Request $request)
    {
        $doctorRepository = $this->getDoctorRepository();
        $doctor = $doctorRepository->selectById((int)$request->get('doctorId'));

        if (null === $doctor) {
            return new JsonResponse(
                [
                    'msg' => 'No doctor information received',
                ]
            );
        }

        $serialized = [];
        $patients = $this->getPatientRepository()->selectByDoctor($doctor);

        foreach ($patients as $patient) {
            $serialized[] = [
                'id' => $patient->getId(),
                'name' => $patient->getName(),
            ];
        }

        return new JsonResponse(
            [
                'patients' => $serialized,
                'doctor' => [
                    'id' => $doctor->getId(),
                    'name' => $doctor->getName(),
                ],
                'msg' => 'Here are the patients for ' . $doctor->getName(),
            ]
        );
    }

    /**
     * @return DoctorRepository
     */
    private function getDoctorRepository()
    {
        return $this->get('doctor_repository');
    }

    /**
     * @return PatientRepository
     */
    private function getPatientRepository()
    {
        return $this->get('patient_repository');
    }
}
