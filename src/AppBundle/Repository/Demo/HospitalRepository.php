<?php

namespace AppBundle\Repository\Demo;

use AppBundle\Entity\Hospital;
use AppBundle\Provider\DataProviderInterface;
use AppBundle\Repository\HospitalRepository as BaseRepository;

class HospitalRepository extends BaseRepository
{
    /** @var Hospital[]|array */
    protected $data = [];

    /**
     * @param DataProviderInterface $dataProvider
     */
    public function __construct(DataProviderInterface $dataProvider)
    {
        $this->data = $dataProvider->getData()['hospitals'];
    }

    /**
     * @param int $id
     *
     * @return Hospital|null
     */
    public function selectById($id)
    {
        $result = array_filter(
            $this->data,
            function ($hospital) use ($id) {
                return $hospital->getId() === $id;
            }
        );

        return reset($result) ?: null;
    }
}
