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

    function setLanguate($language);

    function getLanguage();

    function getOrderNumber();

    function setOrderNumber();

    function getResponseFingerprint($responseFingerprint);

    function setResponseFingerprint();

    function getResponseFingerprintOrder($responseFingerprintOrder);

    function setResponseFingerprintOrder();

    function getAnonymousPan($anonymousPan);

    function setAnonymousPan();

    function getAuthenticated($authenticated);

    function setAuthenticated();

    function getMessage($message);

    function setMessage();

    function getExpiry($expiry);

    function setExpiry();

    function getCardholder($cardholder);

    function setCardholder();

    function getMaskedPan($maskedPan);

    function setMaskedPan();

    function setCreatedAt(\DateTime $createdAt);

    function getCreatedAt();
}