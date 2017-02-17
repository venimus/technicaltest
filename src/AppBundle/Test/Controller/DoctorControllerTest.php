<?php

namespace AppBundle\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DoctorControllerTest extends WebTestCase
{

    public function testGetPatients()
    {
        $client = static::createClient();
        $client->request('GET', '/showdoctorpatients/1');

        $this->assertEquals(
            '{"patients":[{"id":1,"name":"Demo Patient 1"}],' .
            '"doctor":{"id":1,"name":"Demo Doctor 1"},' .
            '"msg":"Here are the patients for Demo Doctor 1"}',
            $client->getResponse()->getContent()
        );
    }
}
