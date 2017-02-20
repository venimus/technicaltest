<?php

namespace AppBundle\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Simple param converter that uses param name to guess the repository then fetches by selectById()
 */
class DemoParamConverter implements ParamConverterInterface
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Stores the object in the request.
     *
     * @param Request $request              The request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool True if the object has been successfully set, else false
     * @throws ServiceNotFoundException
     * @throws ServiceCircularReferenceException
     * @throws NotFoundHttpException
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $name = $configuration->getName();
        $class = $configuration->getClass();
        $repo = $name . '_repository';

        try {
            $object = $this->container
                ->get($repo)
                ->selectById((int)$request->get($name))
            ;
        } catch (ServiceNotFoundException $exception) {
            throw new NotFoundHttpException(sprintf('%s not found.', $repo));
        }

        if (null === $object && false === $configuration->isOptional()) {
            throw new NotFoundHttpException(sprintf('%s not found.', $class));
        }
        $request->attributes->set($name, $object);

        return true;
    }

    /**
     * Checks if the object is supported.
     *
     * @param ParamConverter $configuration Should be an instance of ParamConverter
     *
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        $name = $configuration->getName();
        $repo = $name . '_repository';

        try {
            $this->container->get($repo);

            return true;
        } catch (ServiceNotFoundException $exception) {
            return false;
        }
    }
}
