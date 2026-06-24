<?php

namespace App\Ai\Agents;

use App\Ai\Tools\CustomerHistory;
use App\Ai\Tools\OrderLookup;
use App\Models\KnowledgeArticle;
use Laravel\Ai\Attributes\MaxSteps;
use Laravel\Ai\Attributes\MaxTokens;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\Temperature;
use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Laravel\Ai\Providers\Tools\FileSearch;
use Laravel\Ai\Tools\SimilaritySearch;
use Stringable;

#[MaxSteps(5)]
#[MaxTokens(600)]
#[Temperature(0.7)]
#[Provider(Lab::Ollama)]
//#[Model('qwen2.5-coder:7b-instruct-q5_K_M')]
// #[Model('gemma3:270m')]
 #[Model('qwen3.5:4b-mlx')]
// #[Provider(Lab::Gemini)]
// #[Model('gemini-2.5-flash')]

class SupportAgent implements Agent, HasTools, Conversational
{
    use Promptable, RemembersConversations;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return <<<'PROMPT'
            You are a friendly, professional customer support agent for an online store.

            Guidelines:
            - Be empathetic and acknowledge the customer's concern
            - Ask clarifying questions when needed
            - Provide clear, actionable next steps
            - Keep responses concise but helpful
            - If you cannot resolve an issue, let the customer know a human agent will follow up
            - When a customer mentions an order number, use the OrderLookup tool to get real data
            - When a customer provides their email, use the CustomerHistory tool for context
            - For quick FAQ-style questions, use the knowledge base search tool
            - For detailed policy questions, use the FileSearch tool to find specific documentation
            - Always base policy answers on the knowledge base - never make up policies
            - When citing policies, be specific about timelines and conditions
        PROMPT;


    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [
            new CustomerHistory,
            new OrderLookup,

            SimilaritySearch::usingModel(KnowledgeArticle::class, 'embedding')
                ->withDescription('Search the company knowledge base for policies,
                procedures, and FAQ answers. Use this when a customer asks about returns,
                shipping, billing, account issues, or any company policy.'),

           // new FileSearch(stores: [config('ai.vector_store_id')]),

            ];
    }
}
