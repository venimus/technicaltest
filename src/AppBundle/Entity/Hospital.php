<?php

namespace AppBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class Hospital
{
    /**
     * @Serializer\Expose
     * @Serializer\Groups({"default"})
     * @var int
     */
    private $id;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"default"})
     * @var string
     */
    private $name;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"hospital"})
     *
     * @var Patient[]|array
     */
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
     * @return $this
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
        $patient->setHospital($this);

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
        $patient->setHospital();

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Hospital
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return Hospital
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
