<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Doctor;
use AppBundle\Entity\Hospital;
use AppBundle\Entity\Patient;

class PatientRepository implements RepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Patient
     */
    public function selectById($id)
    {
        return null;
    }

    /**
     * @param Hospital $hospital
     *
     * @return Patient[]
     */
    public function selectByHospital(Hospital $hospital)
    {
        return [];
    }

    /**
     * @param Doctor $doctor
     *
     * @return Patient[]
     */
    public function selectByDoctor(Doctor $doctor)
    {
        return [];
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
        return $patient;
    }
}
