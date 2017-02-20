<?php

namespace AppBundle\Repository\Demo;

use AppBundle\Entity\Doctor;
use AppBundle\Entity\Hospital;
use AppBundle\Entity\Patient;
use AppBundle\Provider\DataProviderInterface;
use AppBundle\Repository\PatientRepository as BaseRepository;

class PatientRepository extends BaseRepository
{
    /** @var Patient[]|array */
    protected $data = [];

    /**
     * @param DataProviderInterface $dataProvider
     */
    public function __construct(DataProviderInterface $dataProvider)
    {
        $this->data = $dataProvider->getData()['patients'];
    }

    /**
     * @param int $id
     *
     * @return Patient|null
     */
    public function selectById($id)
    {
        $result = array_filter(
            $this->data,
            function ($patient) use ($id) {
                return $patient->getId() === $id;
            }
        );

        return reset($result) ?: null;
    }

    /**
     * @param Hospital $hospital
     *
     * @return Patient[]
     */
    public function selectByHospital(Hospital $hospital)
    {
        return array_filter(
            $this->data,
            function ($patient) use ($hospital) {
                return $patient->getHospital()->getId() === $hospital->getId();
            }
        );
    }

    /**
     * @param Doctor $doctor
     *
     * @return Patient[]
     */
    public function selectByDoctor(Doctor $doctor)
    {
        return array_filter(
            $this->data,
            function ($patient) use ($doctor) {
                return $patient->getDoctor()->getId() === $doctor->getId();
            }
        );
    }
    /**
     * @return Patient[]
     */
    public function selectAll()
    {
        return $this->data;
    }
    /**
     * Persists a new patient
     *
     * @param Patient $patient
     *
     * @return Patient
     */
    public function save(Patient $patient)
    {
        if (!$this->selectById($patient->getId())) {
            // new patient
            $this->data[] = $patient;

            return $patient;
        }

        // update stored patient with new data
        $this->data = array_map(
            function ($storedPatient) use ($patient) {
                if ($storedPatient->getId() === $patient->getId()) {
                    return $patient;
                }

                return $storedPatient;
            },
            $this->data
        );

        return $patient;
    }
}
