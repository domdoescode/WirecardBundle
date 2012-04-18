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

use DomUdall\WirecardBundle\Exception\InvalidFinancialInstitutionException;
use DomUdall\WirecardBundle\Exception\InvalidPaymentTypeException;
use DomUdall\WirecardBundle\Exception\InvalidPaymentTypeFinancialInstitutionCombinationException;

use \NumberFormatter;

abstract class PaymentRequest implements PaymentRequestInterface
{
    /**
     * Payment types as defined by QPAY
     */
    protected $paymentTypes = array(
        "SELECT",
        "CCARD",
        "CCARD-MOTO",
        "MAESTRO",
        "PBX",
        "PSC",
        "EPS",
        "ELV",
        "QUICK",
        "IDL",
        "GIROPAY",
        "PAYPAL",
        "SOFORTUEBERWEISUNG",
    );

    /**
     * Payment types with their valid financial institutions
     */
    protected $validPaymentTypeFinancialInstitutionCombos = array(
      "CCARD" => array(
        "MC",
        "Visa",
        "Amex",
        "Dine,rs",
        "JCB",
      ),
      "CCARD-MOTO" => array(
        "MC",
        "Visa",
        "Amex",
        "Dine,rs",
        "JCB",
      ),
      "EPS" => array(
        "BA-CA",
        "BB-Racon",
        "ARZ|BAF",
        "ARZ|BCS",
        "Bawag|B",
        "ARZ|VB",
        "Bawag|E",
        "Spardat|EBS",
        "ARZ|GB",
        "ARZ|HAA",
        "ARZ|HI",
        "Hypo-Racon|O",
        "Hypo-Racon|S",
        "Hypo-Racon|ST",
        "ARZ|HTB",
        "ARZ|IB",
        "ARZ|IKB",
        "ARZ|NLH",
        "ARZ|AB",
        "ARZ|BSS",
        "Bawag|P",
        "Racon",
        "Bawag|S",
        "ARZ|VLH",
        "ARZ|SB",
        "ARZ|SBL",
        "ARZ|SBVI",
      ),
      "IDL" => array(
        "ABNAMROBANK",
        "POSTBANK",
        "RABOBANK",
        "SNSBANK",
        "ASNBANK",
        "REGIOBANK",
        "TRIODOSBANK",
        "VANLANSCHOT",
      ),
      "MAESTRO" => "MAESTRO",
      "PBX" => "PBX",
      "ELV" => "ELV",
      "QUICK" => "QUICK",
      "GIROPAY" => "GIROPAY",
      "PAYPAL" => "PAYPAL",
      "SOFORTUEBERWEISUNG" => "SOFORTUEBERWEISUNG",

      // C2P given in financial institutions, but C2P not given in payment types...
      // "C2P" => "C2P",
    );

    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $locale
     */
    protected $locale;

    /**
     * @var NumberFormatter $numberFormatter
     */
    protected $numberFormatter;

    /**
     * @var float $amount
     */
    protected $amount = 0;

    /**
     * @var string $currency
     */
    protected $currency = "EUR";

    /**
     * @var string $paymentType
     */
    protected $paymentType = "SELECT";

    /**
     * @var string $financialInstitution
     */
    protected $financialInstitution;

    /**
     * @var DateTime $createdAt
     */
    protected $createdAt;


    /**
     * Sets the locale of the currency system.
     * 
     * Defaults to de_DE due to Wirecard's EUR default, and German location.
     */
    public function __construct($locale = 'de_DE')
    {
        $this->setLocale($locale);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the amount of the payment request
     *
     * @param float $amount
     */
    public function setAmount($amount)
    {
        if (!is_numeric($amount)) {
            throw new \InvalidArgumentException(sprintf('Payment request amount must be set to a numeric value, %s given.', gettype($amount)));
        }
        $this->amount = (float)$amount;
    }

    /**
     * Get the amount of the payment request
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets the payment type of the payment request
     */
    public function setPaymentType($paymentType)
    {
        if (!in_array($paymentType, $this->paymentTypes)) {
            $validPaymentTypes = implode(", ", $this->paymentTypes);
            throw new InvalidPaymentTypeException(sprintf('Payment request amount must be valid for QPAY (%s), %s given.', $validPaymentTypes, $paymentType));
        }
        $this->paymentType = $paymentType;
    }

    /**
     * Gets the payment type of the payment request
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    public function setFinancialInstitution($financialInstitution)
    {
        $this->validateFinancialInstitution($financialInstitution);
        $this->financialInstitution = $financialInstitution;
    }

    public function getFinancialInstitution()
    {
        return $this->financialInstitution;
    }

    public function validateFinancialInstitution($financialInstitution)
    {
        if (array_key_exists($this->paymentType, $this->validPaymentTypeFinancialInstitutionCombos)) {
            $validInstitutes = $this->validPaymentTypeFinancialInstitutionCombos[$this->paymentType];
            if (!is_array($validInstitutes)) {
                $validInstitutes = array($validInstitutes);
            }

            if (!in_array($financialInstitution, $validInstitutes)) {
                throw new InvalidPaymentTypeFinancialInstitutionCombinationException($financialInstitution . ' cannot be set when payment type is ' . $this->paymentType);
            }
        } else {
            throw new InvalidFinancialInstitutionException('Financial institution cannot be set with any payment type.');
        }
    }

    /**
     * Sets the locale of the payment request, as well as the number formatter to use
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        $this->numberFormatter = new NumberFormatter($this->locale, NumberFormatter::CURRENCY);
    }

    /**
     * Gets the locale of the payment request
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Get the number formatter created based on the payment locale
     */
    public function getCurrencyCode()
    {
        return $this->numberFormatter->getTextAttribute(NumberFormatter::CURRENCY_CODE);
    }

    /**
     * Set the date when the payment request was created
     *
     * @param DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get the date when the payment request was created
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
