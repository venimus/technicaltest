<?php

namespace AppBundle\Provider;

/**
 * This interface is responsible for providing data to repositories
 */
interface DataProviderInterface
{
    /**
     * Get data for repository
     *
     * @return array
     */
    public function getData();
}
