<?php

namespace AppBundle\Provider;

use Symfony\Component\DependencyInjection\ContainerInterface;

use AppBundle\Entity\Doctor;
use AppBundle\Entity\Hospital;
use AppBundle\Entity\Patient;

/**
 * This class is responsible for loading some demo data
 */
class DemoDataProvider implements DataProviderInterface
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {

        $patient1 = new Patient();
        $patient1->setId(1);
        $patient1->setName('Demo Patient 1');

        $patient2 = new Patient();
        $patient2->setId(2);
        $patient2->setName('Demo Patient 2');

        $doctor1 = new Doctor();
        $doctor1->setName('Demo Doctor 1');
        $doctor1->setId(1);
        $doctor1->addPatient($patient1);

        $doctor2 = new Doctor();
        $doctor2->setName('Demo Doctor 2');
        $doctor2->setId(2);
        $doctor2->addPatient($patient2);

        $hospital1 = new Hospital();
        $hospital1->setId(1);
        $hospital1->setName('Demo Hospital 1');
        $hospital1->addPatient($patient1);
        $hospital1->addPatient($patient2);


        $hospital2 = new Hospital();
        $hospital2->setId(2);
        $hospital2->setName('Demo Hospital 2');

        $this->data = [
            'hospitals' => [$hospital1, $hospital2],
            'patients' => [$patient1, $patient2],
            'doctors' => [$doctor1, $doctor2],
        ];
    }

    public function getData()
    {
        return $this->data;
    }
}
