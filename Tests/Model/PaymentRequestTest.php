<?php

/**
 * This file is part of the DomUdallWirecardBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Dom Udall <dom@synthmedia.co.uk>
 */

namespace DomUdall\WirecardBundle\Tests\Model;

use DomUdall\WirecardBundle\Exception\InvalidFinancialInstitutionException;
use DomUdall\WirecardBundle\Exception\InvalidPaymentTypeException;
use DomUdall\WirecardBundle\Exception\InvalidPaymentTypeFinancialInstitutionCombinationException;

use DomUdall\WirecardBundle\Model\PaymentRequest;

class PaymentRequestTest extends \PHPUnit_Framework_TestCase
{
    public static $paymentTypes = array(
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

    public static $paymentTypesNoFinancialInstitutions = array(
        "SELECT",
        "PSC",
    );

    public static $financialInstitutions = array(
        "MC",
        "Visa",
        "Amex",
        "Diners",
        "JCB",
        "MAESTRO",
        "PBX",
        "ELV",
        "QUICK",
        "C2P",
        "GIROPAY",
        "PAYPAL",
        "SOFORTUEBERWEISUNG",
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
        "ABNAMROBANK",
        "POSTBANK",
        "RABOBANK",
        "SNSBANK",
        "ASNBANK",
        "REGIOBANK",
        "TRIODOSBANK",
        "VANLANSCHOT",
    );

    public static $validPaymentTypeFinancialInstitutionCombos = array(
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

    public static function validAmounts()
    {
        return array(
            array(0, 0),
            array(1, 1),
            array(100.1, 100.1),
            array(1001, 1001),
            array(1.00, 1),
            array(1.000001, 1.000001),
            array(1.1, 1.1),
            array("0", 0),
            array("1", 1),
            array("100.1", 100.1),
            array("1001", 1001),
            array("1.00", 1),
            array("1.000001", 1.000001),
            array("1.1", 1.1)
        );
    }

    public static function invalidAmounts()
    {
        $object = new \stdClass();
        return array(
            array(null),
            array(true),
            array(false),
            array("text"),
            array(""),
            array($object),
        );
    }

    public static function validPaymentTypeFinancialInstitutionCombos()
    {
        $validValues = array();
        foreach (self::$validPaymentTypeFinancialInstitutionCombos as $paymentType => $institutions) {
            if (!is_array($institutions)) {
                $institutions = array($institutions);
            }

            foreach ($institutions as $institution) {
                $validValues[] = array($paymentType, $institution);
            }
        }
        return $validValues;
    }

    public static function invalidPaymentTypeFinancialInstitutionCombos()
    {
        $invalidValues = array();
        $validCombos = self::$validPaymentTypeFinancialInstitutionCombos;
        $financialInstitutions = self::$financialInstitutions;
        $paymentTypes = self::$paymentTypes;

        $paymentTypesFlipped = array_flip($paymentTypes);
        foreach (self::$paymentTypesNoFinancialInstitutions as $paymentType) {
            if (!array_key_exists($paymentType, $validCombos)) {
                $key = $paymentTypesFlipped[$paymentType];
                unset($paymentTypes[$key]);
            }
        }
        unset($paymentTypesFlipped);

        foreach ($paymentTypes as $paymentType) {
            if (!array_key_exists($paymentType, $validCombos)) {
                foreach ($financialInstitutions as $institution) {
                    $invalidValues[] = array($paymentType, $institution);
                }
            } else {
                $validInstitutes = $validCombos[$paymentType];
                if (!is_array($validInstitutes)) {
                    $validInstitutes = array($validInstitutes);
                }

                foreach ($financialInstitutions as $institution) {
                    if (!in_array($institution, $validInstitutes)) {
                        $invalidValues[] = array($paymentType, $institution);
                    }
                }
            }
        }

        return $invalidValues;
    }
    
    public static function noPaymentTypeFinancialInstitutions()
    {
        $noValues = array();
        foreach (self::$paymentTypesNoFinancialInstitutions as $paymentType) {
            foreach (self::$financialInstitutions as $institution) {
                $noValues[] = array($paymentType, $institution);
            }
        }
        return $noValues;
    }

    public function testId()
    {
        $paymentRequest = $this->getPaymentRequest();
        $this->assertNull($paymentRequest->getId());
    }

    public function testInitialAmount()
    {
        $paymentRequest = $this->getPaymentRequest();
        $this->assertEquals(0, $paymentRequest->getAmount());
    }

    /**
     * @dataProvider validAmounts
     */
    public function testValidAmount($amount, $expected)
    {
        $paymentRequest = $this->getPaymentRequest();
        $paymentRequest->setAmount($amount);
        $this->assertEquals($expected, $paymentRequest->getAmount());
    }

    /**
     * @dataProvider invalidAmounts
     */
    public function testInvalidAmount($amount)
    {
        $paymentRequest = $this->getPaymentRequest();

        try {
            $paymentRequest->setAmount($amount);
            $this->fail('An expected exception has not been raised.');
        } catch (\InvalidArgumentException $e) {
        }
        return;
    }

    public function testPaymentType()
    {
        $paymentRequest = $this->getPaymentRequest();
        $this->assertEquals("SELECT", $paymentRequest->getPaymentType());

        $paymentRequest->setPaymentType("PAYPAL");
        $this->assertEquals("PAYPAL", $paymentRequest->getPaymentType());

        try {
            $paymentRequest->setPaymentType('Not a valid payment type');
            $this->fail('An expected exception has not been raised.');
        } catch (InvalidPaymentTypeException $e) {
        }
        return;
    }

    public function testInitialFinancialInstitution()
    {
        $paymentRequest = $this->getPaymentRequest();
        $this->assertNull($paymentRequest->getFinancialInstitution());
    }

    /**
     * @dataProvider validPaymentTypeFinancialInstitutionCombos
     */
    public function testValidFinancialInstitution($paymentType, $institution)
    {
        $paymentRequest = $this->getPaymentRequest();
        $paymentRequest->setPaymentType($paymentType);
        $paymentRequest->setFinancialInstitution($institution);

        $this->assertEquals($institution, $paymentRequest->getFinancialInstitution());
    }

    /**
     * @dataProvider invalidPaymentTypeFinancialInstitutionCombos
     */
    public function testInvalidFinancialInstitution($paymentType, $institution)
    {
        $paymentRequest = $this->getPaymentRequest();
        $paymentRequest->setPaymentType($paymentType);

        try {
            $paymentRequest->setFinancialInstitution($institution);
            $this->fail($institution . ' is not allowed with ' . $paymentType . ' payment type.');
        } catch (InvalidPaymentTypeFinancialInstitutionCombinationException $e) {
            return;
        }
    }

    /**
     * @dataProvider noPaymentTypeFinancialInstitutions
     */
    public function testNoFinancialInstitutionAllowed($paymentType, $institution)
    {
        $paymentRequest = $this->getPaymentRequest();
        $paymentRequest->setPaymentType($paymentType);

        try {
            $paymentRequest->setFinancialInstitution($institution);
        } catch (InvalidFinancialInstitutionException $e) {
            return;
        }
        $this->fail($institution . ' should not be allowed with any payment type.');
    }

    public function testLocale()
    {
        $paymentRequest = $this->getPaymentRequest();
        $this->assertEquals("de_DE", $paymentRequest->getLocale());

        $paymentRequest->setLocale("en_US");
        $this->assertEquals("en_US", $paymentRequest->getLocale());

        $paymentRequest->setLocale("en_GB");
        $this->assertEquals("en_GB", $paymentRequest->getLocale());
    }

    public function testCurrencyCode()
    {
        $paymentRequest = $this->getPaymentRequest();
        $this->assertEquals("EUR", $paymentRequest->getCurrencyCode());

        $paymentRequest->setLocale("en_US");
        $this->assertEquals("USD", $paymentRequest->getCurrencyCode());

        $paymentRequest->setLocale("en_GB");
        $this->assertEquals("GBP", $paymentRequest->getCurrencyCode());
    }

    public function testCreatedAt()
    {
        $paymentRequest = $this->getPaymentRequest();
        $this->assertNull($paymentRequest->getCreatedAt());

        $now = new \DateTime("now");
        $paymentRequest->setCreatedAt($now);
        $this->assertSame($now, $paymentRequest->getCreatedAt());

        try {
            $paymentRequest->setCreatedAt('not a DateTime object');
        } catch (\Exception $e) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    protected function getPaymentRequest()
    {
        return $this->getMockForAbstractClass('DomUdall\WirecardBundle\Model\PaymentRequest');
    }
}