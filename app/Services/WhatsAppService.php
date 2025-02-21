<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected $apiEndpoint;
    protected $apiKey;
    protected $defaultCountryCode = '91';
    protected $defaultLanguageCode = 'en';

    public function __construct()
    {
        $this->apiEndpoint = config('services.whatsapp.api_endpoint');
        $this->apiKey = config('services.whatsapp.api_key');

        if (!$this->apiEndpoint || !$this->apiKey) {
            throw new \InvalidArgumentException('WhatsApp API configuration is missing.');
        }
    }

    private function sanitizeText(string $text): string
    {
        // Remove tabs, newlines, and reduce multiple spaces to a single space
        return preg_replace('/\s{2,}/', ' ', str_replace(["\t", "\n", "\r"], ' ', $text));
    }


    private function getHeaders(): array
    {
        return [
            'Authorization' => 'Basic ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ];
    }

    public function sendTemplateMessage()
    {
        try {
            $body = [
                "countryCode" => "+91",
                "phoneNumber" => "9822473734",
                "callbackData" => "new text here",
                "type" => "Template",
                "template" => [
                    "name" => "first_msg",
                    "languageCode" => "en"
                ]
            ];

            $response = Http::withHeaders($this->getHeaders())->post($this->apiEndpoint, $body);

            if ($response->successful()) {
                return $response->json();
            }

          \Log::error('WhatsApp API Error', [
                'status' => $response->status(),
                'response_body' => $response->body(),
                'request_body' => $body,
            ]);
            return ['error' => 'Failed to send message', 'details' => $response->json()];
        } catch (\Exception $e) {
            \Log::error('WhatsApp Message Error: ' . $e->getMessage());
            return ['error' => 'Exception occurred', 'details' => $e->getMessage()];
        }
    }

    public function sendTemplateMessage1(
        string $countryCode,
        string $phoneNumber,
        string $templateName,
        string $languageCode,
        string $callbackData = '',
        array $headerValues = [],
        array $bodyValues = [],
        array $buttonValues = []
    ) {
        $countryCode = $countryCode ?? $this->defaultCountryCode;
        $languageCode = $languageCode ?? $this->defaultLanguageCode;
        try {
            $body = [
                "countryCode" => $countryCode,
                "phoneNumber" => $phoneNumber,
                "callbackData" => $callbackData,
                "type" => "Template",
                "template" => [
                    "name" => $templateName,
                    "languageCode" => $languageCode,
                    "headerValues" => $headerValues,
                    "bodyValues" => $bodyValues,
                    "buttonValues" => $buttonValues,
                ],
            ];

            $response = Http::withHeaders($this->getHeaders())->post($this->apiEndpoint, $body);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('WhatsApp API Error', [
                'status' => $response->status(),
                'response_body' => $response->body(),
                'request_body' => $body,
            ]);

            return ['error' => 'Failed to send message', 'details' => $response->json()];
        } catch (\Exception $e) {
            Log::error('WhatsApp API Exception', ['message' => $e->getMessage()]);
            return ['error' => 'Exception occurred', 'details' => $e->getMessage()];
        }
    }

    public function sendNewEnquiryMessage(
        string $countryCode,
        string $phoneNumber,
        string $callbackData = '',
        array $bodyValues = [],
    ) {
        $templateName="dmc_new_enquiry_update";
        $countryCode = $countryCode ?? $this->defaultCountryCode;
        try {
            $sanitizedBodyValues = array_map(fn($value) => $this->sanitizeText($value), $bodyValues);

            $body = [
                "countryCode" => '+'.$countryCode,
                "phoneNumber" => $phoneNumber,
                "callbackData" => $callbackData,
                "type" => "Template",
                "template" => [
                    "name" => $templateName,
                    "languageCode" => $this->languageCode,
                    "bodyValues" => $sanitizedBodyValues,
                ],
            ];

            $response = Http::withHeaders($this->getHeaders())->post($this->apiEndpoint, $body);

            if ($response->successful()) {
                return $response->json();
            }

            \Log::error('WhatsApp API Error', [
                'status' => $response->status(),
                'response_body' => $response->body(),
                'request_body' => $body,
            ]);

            return ['error' => 'Failed to send message', 'details' => $response->json()];
        } catch (\Exception $e) {
            \Log::error('WhatsApp API Exception', ['message' => $e->getMessage()]);
            return ['error' => 'Exception occurred', 'details' => $e->getMessage()];
        }
    }

    public function sendNewBookingGuestUpdateMessage(
        string $countryCode,
        string $phoneNumber,
        string $callbackData = '',
        array $bodyValues = [],
    ) {
        $templateName="dmc_new_booking_guest_update_1";
        $countryCode = $countryCode ?? $this->defaultCountryCode;
        try {
            $sanitizedBodyValues = array_map(fn($value) => $this->sanitizeText($value), $bodyValues);
            $body = [
                "countryCode" => '+'.$countryCode,
                "phoneNumber" => $phoneNumber,
                "callbackData" => $callbackData,
                "type" => "Template",
                "template" => [
                    "name" => $templateName,
                    "languageCode" => $this->defaultLanguageCode,
                    "bodyValues" => $sanitizedBodyValues,
                ],
            ];

            $response = Http::withHeaders($this->getHeaders())->post($this->apiEndpoint, $body);

            if ($response->successful()) {
                return $response->json();
            }

            \Log::error('WhatsApp API Error', [
                'status' => $response->status(),
                'response_body' => $response->body(),
                'request_body' => $body,
            ]);

            return ['error' => 'Failed to send message', 'details' => $response->json()];
        } catch (\Exception $e) {
            \Log::error('WhatsApp API Exception', ['message' => $e->getMessage()]);
            return ['error' => 'Exception occurred', 'details' => $e->getMessage()];
        }
    }


    public function sendNewBookingGuestUpdateMessagePDF(
        string $countryCode,
        string $phoneNumber,
        string $callbackData = '',
        string $pdfUrl,
        array $bodyValues = [],
    ) {
        $templateName="dmc_new_booking_guest_update_1"; //Name of the Whatsapp template
        $countryCode = $countryCode ?? $this->defaultCountryCode;
        $sanitizedBodyValues = array_map(fn($value) => $this->sanitizeText($value), $bodyValues);
        try {

            $body = [
                "countryCode" => '+'.$countryCode,
                "phoneNumber" => $phoneNumber,
                "callbackData" => $callbackData,
                "type" => "document",
                "template" => [
                    "name" => $templateName,
                    "languageCode" => $this->defaultLanguageCode,
                    "bodyValues" => $sanitizedBodyValues,
                ],
                "media" => [
                    [
                        "type" => "document",
                        "url" => $pdfUrl,   // Public link to the PDF file
                        "filename" => "BookingDetails.pdf"
                    ]
                ]
            ];

            $response = Http::withHeaders($this->getHeaders())->post($this->apiEndpoint, $body);

            if ($response->successful()) {
                return $response->json();
            }

            \Log::error('WhatsApp API Error', [
                'status' => $response->status(),
                'response_body' => $response->body(),
                'request_body' => $body,
            ]);

            return ['error' => 'Failed to send message', 'details' => $response->json()];
        } catch (\Exception $e) {
            \Log::error('WhatsApp API Exception', ['message' => $e->getMessage()]);
            return ['error' => 'Exception occurred', 'details' => $e->getMessage()];
        }
    }

}
