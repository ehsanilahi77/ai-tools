<?php

use App\Ai\Agents\SupportAgent;
use App\Ai\Agents\TicketClassifier;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Models\KnowledgeArticle;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-agent', function () {
//    $response = (new SupportAgent)->prompt('Hi, check my order #1042? It was supposed to arrive yesterday');
    $response = (new SupportAgent)->prompt('Hi, my email is sarah@example.com , I think i was charged twice on my recent orders. please confirm');
    return [
        'response' => $response->text,
        'prompt_token' => $response->usage->promptTokens,
        'completion_token' => $response->usage->completionTokens,
        'model' => $response->meta->model,
        'provider' => $response->meta->provider
    ];
});

Route::get('/chat/start', function () {
    $user = User::first();
    $agent = new SupportAgent;

    $response = $agent->forUser($user)->prompt(
        'Hi, my order #1042 seems to be lost. It was supposed to arrive last week.'
    );

    return [
        'reply' => $response->text,
        'conversation_id' => $response->conversationId,
    ];
});

Route::get('/chat/continue/{conversationId}', function (string $conversationId) {
    $user = User::first();
    $agent = new SupportAgent;

    $response = $agent->continue($conversationId, as: $user)->prompt(
        'Can you just send a replacement instead?'
    );

    return $response->text;
});

Route::get('/chat/resume', function () {
    $user = User::first();
    $agent = new SupportAgent;

    $conversationId = session('last_conversation_id');

    $response = $agent->continue($conversationId, as: $user)->prompt(
        'Actually, can you check my email for the shipping confirmation too?'
    );

    return $response->text;
});

Route::get('/classify/test', function () {
//    $result = (new TicketClassifier)->prompt('Hey, just wondering when my package will arrive? Order #1055. No rush, just curious!');
    $result = (new TicketClassifier)->prompt('I was charged twice for my order and nobody is responding to my emails! this is unacceptable!');

    return [
        'category' => $result['category'],
        'priority' => $result['priority'],
        'sentiment' => $result['sentiment'],
        'summary' => $result['summary'],
    ];
});

Route::get('/kb/search', function () {
   $query = request('q', "How do i return a broken item?");

   $results = KnowledgeArticle::query()
       ->whereVectorSimilarTo('embedding', $query)
       ->limit(3)
       ->get();

   return $results->map(fn ($article) => [
       'title' => $article->title,
       'category' => $article->category,
       'excerpt' => str($article->content)->limit(100),
   ]);
});



Route::get('/support/kb-test', function () {
    $resonse = (new SupportAgent)->prompt('What is your return policy for damaged Items ?');
    return $resonse->text;
});


Route::get('support/rag-test', function () {
   $agent = new SupportAgent;
   $user = User::first();

   $response = $agent->forUser($user)->prompt('i receved a demaged Item in my order, what are my options? how
   will a refund takes?');

   return $response->text;
});

Route::post('/chat/stream',[ChatController::class, 'stream'])->middleware('auth');

Route::post('/chat', [ChatController::class, 'send'])->middleware('auth');

Route::get('/chat', function () {
    return view('chat');
})->middleware('auth')->name('chat');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';

Route::post('/tickets',[TicketController::class, 'store'])->middleware('auth');
