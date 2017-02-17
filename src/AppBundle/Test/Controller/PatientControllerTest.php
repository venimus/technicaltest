<?php

namespace AppBundle\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PatientControllerTest extends WebTestCase
{
    public function testCreatePatient()
    {
        $client = static::createClient();
        $client->request('GET', '/createpatient?doctorId=1&hospitalId=1&name=New');

        $this->assertEquals(
            '{"patients":[{"id":1,"name":"Demo Patient 1"},{"id":2,"name":"New"}],' .
            '"doctor":{"id":1,"name":"Demo Doctor 1"},' .
            '"msg":"Here are the patients for Demo Doctor 1"}',
            $client->getResponse()->getContent()
        );
    }
}
