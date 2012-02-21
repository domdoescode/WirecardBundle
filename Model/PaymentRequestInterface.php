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

interface PaymentRequestInterface
{
    function getId();

    function setAmount($amount);

    function getAmount();

    function setPaymentType($paymentType);

    function getPaymentType();

    function setFinancialInstitution($financialInstitution);

    function getFinancialInstitution();

    function validateFinancialInstitution($financialInstitution);

    function setLocale($locale);

    function getLocale();

    function getCurrencyCode();

    function setCreatedAt(\DateTime $createdAt);

    function getCreatedAt();
}