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

abstract class PaymentResponse implements PaymentResponseInterface
{

    protected $id;

    protected $paymentState;

    protected $amount;

    protected $currency;

    protected $paymentType;

    protected $financialInstitution;

    protected $language;

    protected $orderNumber;

    protected $responseFingerprint;

    protected $responseFingerprintOrder;

    protected $anonymousPan;

    protected $authenticated;

    protected $message;

    protected $consumerMessage;

    protected $expiry;

    protected $cardholder;

    protected $maskedPan;

    protected $gatewayReferenceNumber;

    protected $gatewayContractNumber;

    protected $customField1;

    protected $customField2;

    protected $createdAt;


    public function getId() {
        return $this->id;
    }

    public function setPaymentState($paymentState) {
        $this->paymentState = $paymentState;
    }

    public function getPaymentState() {
        return $this->paymentState;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getAmountFormatted()
    {
        return number_format($this->amount, 2);
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    public function getCurrency() {
        return $this->currency;
    }

    public function setPaymentType($paymentType) {
        $this->paymentType = $paymentType;
    }

    public function getPaymentType() {
        return $this->paymentType;
    }

    public function setFinancialInstitution($financialInstitution) {
        $this->financialInstitution = $financialInstitution;
    }

    public function getFinancialInstitution() {
        return $this->financialInstitution;
    }

    public function setLanguage($language) {
        $this->language = $language;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function setOrderNumber($orderNumber) {
        $this->orderNumber = $orderNumber;
    }

    public function getOrderNumber() {
        return $this->orderNumber;
    }

    public function setResponseFingerprint($responseFingerprint) {
        $this->responseFingerprint = $responseFingerprint;
    }

    public function getResponseFingerprint() {
        return $this->responseFingerprint;
    }

    public function setResponseFingerprintOrder($responseFingerprintOrder) {
        $this->responseFingerprintOrder = $responseFingerprintOrder;
    }

    public function getResponseFingerprintOrder() {
        return $this->responseFingerprintOrder;
    }

    public function setAnonymousPan($anonymousPan) {
        $this->anonymousPan = $anonymousPan;
    }

    public function getAnonymousPan() {
        return $this->anonymousPan;
    }

    public function setAuthenticated($authenticated) {
        $this->authenticated = $authenticated;
    }

    public function getAuthenticated() {
        return $this->authenticated;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setConsumerMessage($consumerMessage) {
        $this->consumerMessage = $consumerMessage;
    }

    public function getConsumerMessage() {
        return $this->consumerMessage;
    }

    public function setExpiry($expiry) {
        $this->expiry = $expiry;
    }

    public function getExpiry() {
        return $this->expiry;
    }

    public function setCardholder($cardholder) {
        $this->cardholder = $cardholder;
    }

    public function getCardholder() {
        return $this->cardholder;
    }

    public function setMaskedPan($maskedPan) {
        $this->maskedPan = $maskedPan;
    }

    public function getMaskedPan() {
        return $this->maskedPan;
    }

    public function setGatewayReferenceNumber($gatewayReferenceNumber) {
        $this->gatewayReferenceNumber = $gatewayReferenceNumber;
    }

    public function getGatewayReferenceNumber() {
        return $this->gatewayReferenceNumber;
    }

    public function setGatewayContractNumber($gatewayContractNumber) {
        $this->gatewayContractNumber = $gatewayContractNumber;
    }

    public function getGatewayContractNumber() {
        return $this->gatewayContractNumber;
    }

    public function setCustomField1($customField1) {
        $this->customField1 = $customField1;
    }

    public function getCustomField1() {
        return $this->customField1;
    }

    public function setCustomField2($customField2) {
        $this->customField2 = $customField2;
    }

    public function getCustomField2() {
        return $this->customField2;
    }

    public function setCreatedAt(\DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }
}
