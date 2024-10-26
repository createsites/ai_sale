<!-- resources/views/chat/response.blade.php -->

<p>Ответ ChatGPT:</p>
<div>{{ $response }}</div>
<a href="{{ url('/chat') }}">Задать новый вопрос</a>
