<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FakeOpenAIService;

class ChatController extends Controller
{
    protected $openAIService;

    public function __construct(FakeOpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function ask(Request $request)
    {
        $request->validate([
               'message' => 'required|string',
           ]);

        $response = $this->openAIService->getChatGPTResponse($request->input('message'));

        return view('chat.response', compact('response'));
    }
}
