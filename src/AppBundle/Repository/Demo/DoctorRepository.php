<?php

namespace AppBundle\Repository\Demo;

use AppBundle\Entity\Doctor;
use AppBundle\Provider\DataProviderInterface;
use AppBundle\Repository\DoctorRepository as BaseRepository;

class DoctorRepository extends BaseRepository
{
    /** @var Doctor[]|array */
    protected $data = [];

    /**
     * @param DataProviderInterface $dataProvider
     */
    public function __construct(DataProviderInterface $dataProvider)
    {
        $this->data = $dataProvider->getData()['doctors'];
    }

    /**
     * @param int $id
     *
     * @return Doctor|null
     */
    public function selectById($id)
    {
        $result = array_filter(
            $this->data,
            function ($doctor) use ($id) {
                return $doctor->getId() === $id;
            }
        );

        return reset($result) ?: null;
    }
}
