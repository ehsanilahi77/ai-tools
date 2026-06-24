<div
    x-data="supportChat()"
    class="flex flex-col h-[calc(100vh-11rem)] overflow-hidden rounded-xl border border-vintage-900/40 bg-dark-600 shadow-2xl shadow-black/40"
>
    {{-- Header --}}
    <div class="relative flex items-center gap-3 px-5 py-3.5 border-b border-vintage-900/30 bg-dark-800">
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-brass/30 to-transparent"></div>

        <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-brass/10 border border-brass/25">
            <svg class="w-4 h-4 text-brass animate-flicker" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 0 0-2.455 2.456Z" />
            </svg>
        </div>
        <div>
            <h3 class="font-display text-sm font-semibold text-parchment tracking-wide">SupportAI</h3>
            <p class="text-[11px] text-parchment-dim/50 font-light">Intelligent support &middot; Powered by AI</p>
        </div>
        <div class="ml-auto flex items-center gap-1.5">
            <span class="relative flex h-1.5 w-1.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-patina opacity-60"></span>
                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-patina"></span>
            </span>
            <span class="text-[11px] text-patina font-medium">Online</span>
        </div>
    </div>

    {{-- Messages --}}
    <div
        x-ref="messages"
        class="flex-1 overflow-y-auto px-5 py-5 space-y-4 scroll-smooth"
    >
        {{-- Welcome --}}
        <div x-show="messages.length === 0" class="flex flex-col items-center justify-center h-full text-center animate-fade-in">
            <div class="w-14 h-14 rounded-xl bg-brass/8 border border-brass/15 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-brass/70" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                </svg>
            </div>
            <h4 class="font-display text-base font-semibold text-parchment mb-1.5">How can we assist you?</h4>
            <p class="text-xs text-parchment-dim/50 max-w-xs leading-relaxed">Ask about orders, shipping, returns, or policies. Our AI agent is standing by.</p>
            <div class="mt-6 flex flex-wrap justify-center gap-2">
                <button @click="input = 'What is your return policy?'; sendMessage()" class="px-3 py-1.5 rounded-md bg-dark-400 border border-vintage-900/30 text-xs text-parchment-dim hover:text-brass hover:border-brass/30 transition-all">
                    Return policy
                </button>
                <button @click="input = 'Where is my order #1042?'; sendMessage()" class="px-3 py-1.5 rounded-md bg-dark-400 border border-vintage-900/30 text-xs text-parchment-dim hover:text-brass hover:border-brass/30 transition-all">
                    Track order #1042
                </button>
                <button @click="input = 'What shipping options do you have?'; sendMessage()" class="px-3 py-1.5 rounded-md bg-dark-400 border border-vintage-900/30 text-xs text-parchment-dim hover:text-brass hover:border-brass/30 transition-all">
                    Shipping options
                </button>
            </div>
        </div>

        {{-- Messages --}}
        <template x-for="(msg, index) in messages" :key="index">
            <div
                :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'"
                class="animate-slide-up"
            >
                <div x-show="msg.role === 'assistant'" class="flex-shrink-0 mr-2.5 mt-1">
                    <div class="w-6 h-6 rounded-md bg-brass/10 border border-brass/20 flex items-center justify-center">
                        <svg class="w-3 h-3 text-brass" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z" />
                        </svg>
                    </div>
                </div>

                <div
                    :class="msg.role === 'user'
                        ? 'bg-brass/15 text-parchment border border-brass/20 rounded-2xl rounded-br-sm'
                        : 'bg-dark-400 text-parchment-dim border border-vintage-900/20 rounded-2xl rounded-bl-sm'"
                    class="max-w-[78%] px-4 py-2.5 text-[13px] leading-relaxed"
                >
                    <p x-html="formatMessage(msg.content)" class="whitespace-pre-wrap [&_strong]:font-semibold [&_strong]:text-parchment"></p>
                </div>
            </div>
        </template>

        {{-- Typing indicator --}}
        <div x-show="isStreaming && !currentStream" x-transition class="flex justify-start animate-slide-up">
            <div class="flex-shrink-0 mr-2.5 mt-1">
                <div class="w-6 h-6 rounded-md bg-brass/10 border border-brass/20 flex items-center justify-center">
                    <svg class="w-3 h-3 text-brass" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z" />
                    </svg>
                </div>
            </div>
            <div class="bg-dark-400 border border-vintage-900/20 rounded-2xl rounded-bl-sm px-4 py-3">
                <div class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-brass/50 rounded-full animate-pulse-dot"></span>
                    <span class="w-1.5 h-1.5 bg-brass/50 rounded-full animate-pulse-dot" style="animation-delay: 0.2s"></span>
                    <span class="w-1.5 h-1.5 bg-brass/50 rounded-full animate-pulse-dot" style="animation-delay: 0.4s"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Input --}}
    <div class="border-t border-vintage-900/30 bg-dark-800 px-4 py-3">
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-brass/20 to-transparent"></div>

        <form @submit.prevent="sendMessage" class="flex items-end gap-2.5">
            <div class="flex-1">
                <textarea
                    x-model="input"
                    x-ref="input"
                    :disabled="isStreaming"
                    @keydown.enter.prevent="if (!$event.shiftKey) sendMessage()"
                    rows="1"
                    x-on:input="$el.style.height = 'auto'; $el.style.height = Math.min($el.scrollHeight, 120) + 'px'"
                    placeholder="Type your message..."
                    class="w-full resize-none rounded-lg border-vintage-900/30 bg-dark-500 px-3.5 py-2.5 text-[13px] text-parchment-dim placeholder-parchment-dim/30 focus:border-brass/40 focus:ring-1 focus:ring-brass/20 focus:text-parchment transition-all disabled:opacity-40"
                    style="height: auto; min-height: 40px; max-height: 120px;"
                ></textarea>
            </div>
            <button
                type="submit"
                :disabled="isStreaming || !input.trim()"
                class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-lg bg-brass/15 border border-brass/30 text-brass hover:bg-brass/25 hover:border-brass/40 focus:outline-none focus:ring-1 focus:ring-brass/30 disabled:opacity-25 disabled:hover:bg-brass/15 transition-all"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                </svg>
            </button>
        </form>
    </div>
</div>

<script>
    function supportChat() {
        return {
            messages: [],
            input: '',
            conversationId: null,
            isStreaming: false,
            currentStream: '',

            async sendMessage() {
                const message = this.input.trim();
                if (!message || this.isStreaming) return;

                this.messages.push({ role: 'user', content: message });
                this.input = '';
                this.isStreaming = true;
                this.currentStream = '';

                this.$refs.input.style.height = 'auto';
                this.$refs.input.style.minHeight = '40px';
                this.scrollToBottom();

                try {
                    const response = await fetch('/chat/stream', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            message: message,
                            conversation_id: this.conversationId,
                        }),
                    });

                    this.messages.push({ role: 'assistant', content: '' });
                    const agentIndex = this.messages.length - 1;

                    const reader = response.body.getReader();
                    const decoder = new TextDecoder();

                    while (true) {
                        const { done, value } = await reader.read();
                        if (done) break;

                        const chunk = decoder.decode(value);
                        const lines = chunk.split('\n');

                        for (const line of lines) {
                            if (line.startsWith('data: ')) {
                                try {
                                    const data = JSON.parse(line.slice(6));

                                    if (data.text) {
                                        this.currentStream += data.text;
                                        this.messages[agentIndex].content = this.currentStream;
                                        this.scrollToBottom();
                                    }

                                    if (data.conversation_id) {
                                        this.conversationId = data.conversation_id;
                                    }
                                } catch (e) {
                                    // Skip malformed chunks
                                }
                            }
                        }
                    }
                } catch (error) {
                    this.messages.push({
                        role: 'assistant',
                        content: 'Something went wrong. Please try again.',
                    });
                } finally {
                    this.isStreaming = false;
                    this.currentStream = '';
                }
            },

            formatMessage(content) {
                if (!content) return '';
                return content
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    .replace(/^- /gm, '&bull; ')
                    .replace(/\n/g, '<br>');
            },

            scrollToBottom() {
                this.$nextTick(() => {
                    const container = this.$refs.messages;
                    container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
                });
            },
        };
    }
</script>
