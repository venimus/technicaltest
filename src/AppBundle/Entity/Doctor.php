<?php

namespace AppBundle\Entity;

/**
 * Represents a doctor entity
 */
class Doctor
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var Patient[]|array */
    private $patients = [];

    /**
     * @return Patient[]|array
     */
    public function getPatients()
    {
        return $this->patients;
    }

    /**
     * @param Patient[]|array $patients
     *
     * @return Doctor
     */
    public function setPatients(array $patients)
    {
        $this->patients = $patients;

        return $this;
    }

    /**
     * @param Patient $patient
     *
     * @return $this
     */
    public function addPatient(Patient $patient)
    {
        $this->patients[] = $patient;
        $patient->setDoctor($this);

        return $this;
    }

    /**
     * @param Patient $patient
     *
     * @return $this
     */
    public function removePatient(Patient $patient)
    {
        $this->patients = array_diff($this->patients, [$patient]);
        $patient->setDoctor();

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
