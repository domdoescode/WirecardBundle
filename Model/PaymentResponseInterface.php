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

use Symfony\Component\Security\Core\User\UserInterface;

interface PaymentResponseInterface
{
    function getId();

    function setPaymentState($paymentState);

    function getPaymentState();

    function setAmount($amount);

    function getAmount();

    function setCurrency($currency);

    function getCurrency();

    function setPaymentType($paymentType);

    function getPaymentType();

    function setFinancialInstitution($financialInstitution);

    function getFinancialInstitution();

    function setLanguage($language);

    function getLanguage();

    function setOrderNumber($orderNumber);

    function getOrderNumber();

    function setResponseFingerprint($responseFingerprint);

    function getResponseFingerprint();

    function setResponseFingerprintOrder($responseFingerprintOrder);

    function getResponseFingerprintOrder();

    function setAnonymousPan($anonymousPan);

    function getAnonymousPan();

    function setAuthenticated($authenticated);

    function getAuthenticated();

    function setMessage($message);

    function getMessage();

    function setExpiry($expiry);

    function getExpiry();

    function setCardholder($cardholder);

    function getCardholder();

    function setMaskedPan($maskedPan);

    function getMaskedPan();

    function setCreatedAt(\DateTime $createdAt);

    function getCreatedAt();
}