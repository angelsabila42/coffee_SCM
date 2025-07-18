<?php

namespace App\Services;

require_once __DIR__ . '/OAuth.php';

class PesaPalService
{
    private $consumer_key;
    private $consumer_secret;
    private $iframe_url;
    private $status_url;
    private $callback_url;

    public function __construct()
    {
        $this->consumer_key = config('pesapal.consumer_key');
        $this->consumer_secret = config('pesapal.consumer_secret');
        $this->iframe_url = config('pesapal.iframe_url');
        $this->status_url = config('pesapal.status_url');
        $this->callback_url = config('pesapal.callback_url');
    }

    public function generatePaymentUrl($paymentData)
    {
        $token = $params = NULL;
        $signature_method = new \OAuthSignatureMethod_HMAC_SHA1();

        // Format amount to 2 decimal places
        $amount = number_format($paymentData['amount'], 2);

        // Create XML for PesaPal
        $post_xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
                   "<PesapalDirectOrderInfo xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" " .
                   "xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" " .
                   "Amount=\"{$amount}\" " .
                   "Description=\"{$paymentData['description']}\" " .
                   "Type=\"MERCHANT\" " .
                   "Reference=\"{$paymentData['reference']}\" " .
                   "FirstName=\"{$paymentData['first_name']}\" " .
                   "LastName=\"{$paymentData['last_name']}\" " .
                   "Email=\"{$paymentData['email']}\" " .
                   "PhoneNumber=\"{$paymentData['phone_number']}\" " .
                   "xmlns=\"http://www.pesapal.com\" />";

        $post_xml = htmlentities($post_xml);

        $consumer = new \OAuthConsumer($this->consumer_key, $this->consumer_secret);

        // Generate iframe source URL
        $iframe_src = \OAuthRequest::from_consumer_and_token($consumer, $token, "GET", $this->iframe_url, $params);
        $iframe_src->set_parameter("oauth_callback", $this->callback_url);
        $iframe_src->set_parameter("pesapal_request_data", $post_xml);
        $iframe_src->sign_request($signature_method, $consumer, $token);

        return $iframe_src;
    }

    public function verifyPayment($trackingId, $merchantReference)
    {
        $token = $params = NULL;
        $signature_method = new \OAuthSignatureMethod_HMAC_SHA1();
        $consumer = new \OAuthConsumer($this->consumer_key, $this->consumer_secret);

        // Create status request
        $request_status = \OAuthRequest::from_consumer_and_token($consumer, $token, "GET", $this->status_url, $params);
        $request_status->set_parameter("pesapal_merchant_reference", $merchantReference);
        $request_status->set_parameter("pesapal_transaction_tracking_id", $trackingId);
        $request_status->sign_request($signature_method, $consumer, $token);

        // Execute cURL request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request_status);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        // Extract status from response
        $elements = preg_split("/=/", substr($response, $header_size));
        $status = isset($elements[1]) ? $elements[1] : 'PENDING';

        curl_close($ch);

        return $status;
    }
}
