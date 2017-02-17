<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Doctor;

class DoctorRepository implements RepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Doctor
     */
    public function selectById($id)
    {
        return null;
    }
}
