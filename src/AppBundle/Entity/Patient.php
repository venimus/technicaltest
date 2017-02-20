<?php

namespace AppBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class Patient
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_OTHER = 3;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"default"})
     * @var  int
     */
    private $id;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"default"})
     * @var  string
     */
    private $name;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"default"})
     * @var  \DateTime
     */
    private $dob;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"default"})
     * @var  string
     */
    private $gender;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"patient"})
     *
     * @var  Hospital
     */
    private $hospital;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"patient"})
     *
     * @var Doctor
     */
    private $doctor;

    /**
     * @return Doctor|null
     */
    public function getDoctor()
    {
        return $this->doctor;
    }

    /**
     * @param Doctor|null $doctor
     *
     * @return Patient
     */
    public function setDoctor($doctor = null)
    {
        $this->doctor = $doctor;

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
     * @return Patient
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
     * @return Patient
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @param \DateTime $dob
     *
     * @return Patient
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     *
     * @return Patient
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Hospital
     */
    public function getHospital()
    {
        return $this->hospital;
    }

    /**
     * @param Hospital|null $hospital
     *
     * @return Patient
     */
    public function setHospital($hospital = null)
    {
        $this->hospital = $hospital;

        return $this;
    }
}
