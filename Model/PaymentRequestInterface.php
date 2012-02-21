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

    function setCreatedAt(\DateTime $createdAt);

    function getCreatedAt();

}