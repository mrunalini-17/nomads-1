<?php

namespace App\Http\Controllers;

use App\Services\WhatsAppService;

class WhatsAppController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    public function sendWhatsAppMessage()
    {
        // $to = '+123456789'; // Recipient's phone number
        // $message = 'Hello! This is a test message from Laravel.';

        $response = $this->whatsappService->sendTemplateMessage();

        return response()->json($response);
    }
}
