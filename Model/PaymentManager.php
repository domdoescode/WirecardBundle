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

class PaymentManager
{
    /**
     * Constructor.
     *
     * @param Container               $container
     * @param EntityManager           $em
     * @param string                  $paymentRequestClass
     * @param string                  $paymentResponseClass
     */
    public function __construct($container, EntityManager $em, $paymentRequestClass, $paymentResponseClass)
    {
        $this->container = $container;

        $this->em = $em;
        $this->paymentRequestRepository = $em->getRepository($paymentRequestClass);
        $this->paymentResponseRepository = $em->getRepository($paymentResponseClass);

        $metadata = $em->getClassMetadata($paymentRequestClass);
        $this->paymentRequestClass = $metadata->name;

        $metadata = $em->getClassMetadata($paymentResponseClass);
        $this->paymentResponseClass = $metadata->name;
    }

    /**
     * @return string
     */
    public function getPaymentRequestClass()
    {
        return $this->paymentRequestClass;
    }

    /**
     * @return string
     */
    public function getPaymentResponseClass()
    {
        return $this->paymentResponseClass;
    }

    public function createPaymentRequest()
    {
        return $this->createEntity($this->getPaymentRequestClass);
    }

    public function createPaymentResponse()
    {
        return $this->createEntity($this->getPaymentResponseClass);
    }

    public function mapPaymentRequest($data)
    {
        $paymentRequest = $this->createPaymentRequest();

        $paymentRequest;
        exit;
    }

    public function mapPaymentResponse($data)
    {
        $paymentResponse = $this->createPaymentResponse();

        $paymentResponse;
        exit;
    }

    public function createEntity($class)
    {
        $entity = new $class;
        $entity->setCreatedAt(new \DateTime("now"));

        return $entity;
    }
}