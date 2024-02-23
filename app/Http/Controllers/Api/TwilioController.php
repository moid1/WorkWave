<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\Models\Order;
use App\Models\Customer;

class TwilioController extends Controller
{
    public function sendMessage(Request $request)
    {
        try {
            $orderId = $request->input('order_id');

            $order = Order::findOrFail($orderId);

            $customer = Customer::findOrFail($order->customer_id);

            $phoneNumber = $this->formatPhoneNumber($customer->phone_no);

            $this->sendSMS($phoneNumber, 'Your order has been processed.');

            return response()->json(['message' => 'SMS sent successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    private function sendSMS($to, $message)
    {
        $sid = getenv('TWILIO_SID');
        $token = getenv('TWILIO_AUTH_TOKEN');
        $twilioNumber = '+18669361596';

        $twilio = new Client($sid, $token);

        $twilio->messages->create(
            $to,
            [
                'from' => $twilioNumber,
                'body' => $message,
            ]
        );

    }

    private function formatPhoneNumber($phoneNumber)
{
    // Remove any non-numeric characters from the phone number
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    // Prepend the country code if it's missing
    if (substr($phoneNumber, 0, 1) !== '+') {
        // Extract the country code from the original formatted number
        preg_match('/\+(\d+)/', $phoneNumber, $matches);
        $countryCode = $matches[1] ?? ''; // Extracted country code
        $phoneNumber = '+' . $countryCode . substr($phoneNumber, strlen($countryCode));
    }

    return $phoneNumber;
}

}
