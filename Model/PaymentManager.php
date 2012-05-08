<?php

/**
 * This file is part of the DomUdallWirecardBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Dom Udall <dom@synthmedia.co.uk>
 */

namespace DomUdall\WirecardBundle\Model;

use Doctrine\ORM\EntityManager;

class PaymentManager
{
    /**
     * Constructor.
     *
     * @param Container               $container
     * @param EntityManager           $em
     * @param string                  $paymentResponseClass
     */
    public function __construct($container, EntityManager $em, $paymentResponseClass)
    {
        $this->container = $container;

        $this->em = $em;
        $this->paymentResponseRepository = $em->getRepository($paymentResponseClass);

        $metadata = $em->getClassMetadata($paymentResponseClass);
        $this->paymentResponseClass = $metadata->name;
    }

    /**
     * @return string
     */
    public function getPaymentResponseClass()
    {
        return $this->paymentResponseClass;
    }

    public function createPaymentResponse()
    {
        return $this->createEntity($this->getPaymentResponseClass());
    }

    public function mapPaymentResponse($data)
    {
        $paymentResponse = $this->createPaymentResponse();

        foreach($data as $field => $value) {
            if ($field == "secret") continue;

            $function = "set" . ucwords($field);
            $paymentResponse->$function($value);
        }

        return $paymentResponse;
    }

    public function savePaymentResponse($data)
    {
        if (!isset($data["orderNumber"]) || !$paymentResponse = $this->paymentResponseRepository->findOneBy(array("orderNumber" => $data["orderNumber"]))) {
            $paymentResponse = $this->mapPaymentResponse($data);
            $this->updateEntity($paymentResponse);
        }

        return $paymentResponse;
    }

    public function findUserPaymentResponses($user = null)
    {
        if (!$user) {
            $user = $this->container->get('security.context')->getToken()->getUser();
        }

        $searchCriteria = array(
            "customField1" => $user->getId(),
            "paymentState" => "SUCCESS"
        );

        $paymentResponses = $this->paymentResponseRepository->findBy($searchCriteria);

        $subscriptionManager = $this->container->get('synth_subscription.subscription_manager');
        foreach ($paymentResponses as &$paymentResponse) {
            $subscription = $subscriptionManager->findOneById($paymentResponse->getCustomField2());
            $paymentResponse->subscription = $subscription;
        }

        return $paymentResponses;
    }

    public function findAllUserPaymentResponses()
    {
        $searchCriteria = array(
            "paymentState" => "SUCCESS"
        );

        $paymentResponses = $this->paymentResponseRepository->findBy($searchCriteria);

        $subscriptionManager = $this->container->get('synth_subscription.subscription_manager');
        foreach ($paymentResponses as &$paymentResponse) {
            $subscription = $subscriptionManager->findOneById($paymentResponse->getCustomField2());
            $paymentResponse->subscription = $subscription;
        }

        return $paymentResponses;
    }

    /**
     * Updates an entity.
     *
     * @param $entity
     */
    public function updateEntity($entity, $andFlush = true)
    {
        if ($entity->getId() != null) {
            throw new \Exception("You cannot edit an existing payment!");
        }
        $this->em->persist($entity);

        if ($andFlush) {
            $this->em->flush();
        }
    }

    public function createEntity($class)
    {
        $entity = new $class;
        $entity->setCreatedAt(new \DateTime("now"));

        return $entity;
    }

    public function findOneById($id)
    {
        return $this->paymentResponseRepository->findOneById($id);
    }
}