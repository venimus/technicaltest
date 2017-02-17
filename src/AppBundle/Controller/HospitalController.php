<?php

namespace AppBundle\Controller;

use AppBundle\Repository\PatientRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Repository\HospitalRepository;

class HospitalController extends Controller
{
    /** @var array */
    protected $data;

    /**
     * @Route(
     *     "/showhospitalpatients/{hospitalId}",
     *     name="get_hospital_patients",
     *     requirements={"hospitalId": "\d+"}
     * )
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getPatientsAction(Request $request)
    {

        $hospitalRepository = $this->getHospitalRepository();
        $hospital = $hospitalRepository->selectById((int)$request->get('hospitalId'));

        if (null === $hospital) {
            return new JsonResponse(
                [
                    'msg' => 'No hospital information received',
                ]
            );
        }

        $serialized = [];
        $patients = $this->getPatientRepository()->selectByHospital($hospital);

        foreach ($patients as $patient) {
            $serialized[] = [
                'id' => $patient->getId(),
                'name' => $patient->getName(),
            ];
        }

        return new JsonResponse(
            [
                'patients' => $serialized,
                'hospital' => [
                    'id' => $hospital->getId(),
                    'name' => $hospital->getName(),
                ],
                'msg' => 'Here are the patients for ' . $hospital->getName(),
            ]
        );
    }

    /**
     * @return HospitalRepository
     */
    private function getHospitalRepository()
    {
        return $this->get('hospital_repository');
    }

    /**
     * @return PatientRepository
     */
    private function getPatientRepository()
    {
        return $this->get('patient_repository');
    }
}
