<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Doctor;
use AppBundle\Entity\Patient;
use AppBundle\Repository\RepositoryInterface;

class PatientController extends Controller
{
    /** @var array */
    protected $data;

    /**
     * @Route("/createpatient", name="post_patient")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createPatientAction(Request $request)
    {
        $doctor = $this->getDoctorRepository()->selectById((int)$request->get('doctorId'));

        if (null === $doctor) {
            return new JsonResponse(
                [
                    'msg' => 'No doctor information received',
                ]
            );
        }

        $hospital = $this->getHospitalRepository()->selectById((int)$request->get('hospitalId'));

        if (null === $hospital) {
            return new JsonResponse(
                [
                    'msg' => 'No hospital information received',
                ]
            );
        }

        $name = $request->get('name');

        if (empty($name)) {
            return new JsonResponse(
                [
                    'msg' => 'No name information received',
                ]
            );
        }

        $patient = new Patient();
        $patient->setName($name);
        $patient->setDoctor($doctor);
        $patient->setHospital($hospital);
        $patient->setId(count($doctor->getPatients()) + 1);

        $patient = $this->getPatientRepository()->save($patient);

        $doctor->addPatient($patient);
        $hospital->addPatient($patient);

        $serialized = $this->serializePatients($doctor);

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
     * Return serialized collection of patients
     *
     * @param Doctor $doctor
     *
     * @return array
     */
    private function serializePatients(Doctor $doctor)
    {
        $serialized = [];
        $patients = $this->getPatientRepository()->selectByDoctor($doctor);

        foreach ($patients as $patient) {
            $serialized[] = [
                'id' => $patient->getId(),
                'name' => $patient->getName(),
            ];
        }

        return $serialized;
    }

    /**
     * @return RepositoryInterface
     */
    private function getDoctorRepository()
    {
        return $this->get('doctor_repository');
    }

    /**
     * @return RepositoryInterface
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
