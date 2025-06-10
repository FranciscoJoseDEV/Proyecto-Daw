<style>
    #chatbot {
        position: fixed;
        right: 30px;
        bottom: 30px;
        width: 350px;
        max-width: 95vw;
        background-color: #F2EFE7;
        border: 3px solid #9ACBD0;
        border-radius: 18px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
        padding: 0;
        display: none;
        font-size: 15px;
        height: 540px;
        z-index: 1000;
        animation: chatbot-pop 0.3s;
        flex-direction: column;
        overflow: hidden;
    }

    @keyframes chatbot-pop {
        0% {
            transform: scale(0.8);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    #chatbot-header {
        background: #9ACBD0;
        color: #F2EFE7;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 15px 15px 0 0;
        font-weight: bold;
        font-size: 1.1em;
        letter-spacing: 1px;
    }

    #chatbot-header .close-btn {
        background: none;
        border: none;
        color: #F2EFE7;
        font-size: 1.3em;
        cursor: pointer;
        transition: color 0.2s;
    }

    #chatbot-header .close-btn:hover {
        color: #fff;
    }

    #chatbot-messages {
        flex: 1;
        padding: 18px 12px 12px 12px;
        overflow-y: auto;
        background: #fff;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .chat-bubble {
        max-width: 80%;
        padding: 10px 14px;
        border-radius: 16px;
        margin-bottom: 2px;
        font-size: 1em;
        word-break: break-word;
        box-shadow: 0 2px 8px rgba(154, 203, 208, 0.07);
    }

    .chat-bubble.user {
        align-self: flex-end;
        background: #9ACBD0;
        color: #fff;
        border-bottom-right-radius: 4px;
    }

    .chat-bubble.bot {
        align-self: flex-start;
        background: #F2EFE7;
        color: #222;
        border-bottom-left-radius: 4px;
        border: 1.5px solid #9ACBD0;
    }

    #chatbot-input-area {
        display: flex;
        gap: 8px;
        padding: 12px 14px 14px 14px;
        background: #F2EFE7;
        border-top: 1.5px solid #9ACBD0;
    }

    #userInput {
        flex: 1;
        border: 1.5px solid #9ACBD0;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 1em;
        background: #fff;
        color: #222;
        outline: none;
        transition: border 0.2s;
    }

    #userInput:focus {
        border: 1.5px solid #7bb3b7;
    }

    #send-btn {
        background: #9ACBD0;
        color: #F2EFE7;
        border: none;
        border-radius: 8px;
        padding: 8px 18px;
        font-weight: bold;
        font-size: 1em;
        cursor: pointer;
        transition: background 0.2s;
    }

    #send-btn:hover {
        background: #7bb3b7;
    }

    #chatbot-toggle {
        position: fixed;
        right: 30px;
        bottom: 30px;
        background-color: #9ACBD0;
        color: #F2EFE7;
        padding: 18px 22px;
        border-radius: 50%;
        font-size: 32px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
        border: 2px solid #F2EFE7;
        transition: background 0.2s;
        z-index: 1001;
    }

    #chatbot-toggle:hover {
        background-color: #7bb3b7;
    }
</style>

<div id="chatbot">
    <div id="chatbot-header">
        <span>🧑‍💼 Tu Padre Rico</span>
        <button class="close-btn" onclick="toggleChatbot()">&times;</button>
    </div>
    <div id="chatbot-messages"></div>
    <div id="chatbot-input-area">
        <input type="text" class="form-control" id="userInput" placeholder="Pregúntale a tu padre..."
            onkeydown="if(event.key==='Enter'){sendMessage();}">
        <button id="send-btn" onclick="sendMessage()">Enviar</button>
    </div>
</div>

<button id="chatbot-toggle" onclick="toggleChatbot()">🗨️</button>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    function toggleChatbot() {
        const chatbot = document.getElementById('chatbot');
        const toggleBtn = document.getElementById('chatbot-toggle');
        const isOpen = chatbot.style.display === 'flex';
        chatbot.style.display = isOpen ? 'none' : 'flex';
        toggleBtn.style.display = isOpen ? 'block' : 'none';
        if (!isOpen) {
            setTimeout(() => {
                document.getElementById('userInput').focus();
            }, 200);
        }
    }

    function appendMessage(content, sender = 'bot') {
        const messagesDiv = document.getElementById('chatbot-messages');
        const bubble = document.createElement('div');
        bubble.className = 'chat-bubble ' + sender;
        if (sender === 'bot') {
            bubble.innerHTML = marked.parse(content);
        } else {
            bubble.textContent = content;
        }
        messagesDiv.appendChild(bubble);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    async function sendMessage() {
        const input = document.getElementById('userInput');
        const text = input.value.trim();
        if (!text) return;
        appendMessage(text, 'user');
        input.value = '';
        appendMessage('Consultando el WallStreet journal...', 'bot');
        try {
            const response = await fetch('/api/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify({
                    message: text
                }),
            });

            // Intenta parsear como JSON, si falla muestra error amigable
            let data;
            try {
                data = await response.json();
            } catch (e) {
                // Elimina el mensaje de "Consultando..."
                const messagesDiv = document.getElementById('chatbot-messages');
                messagesDiv.removeChild(messagesDiv.lastChild);
                appendMessage('Error: El servidor no respondió correctamente. Intenta más tarde.', 'bot');
                return;
            }

            // Elimina el mensaje de "Consultando..."
            const messagesDiv = document.getElementById('chatbot-messages');
            messagesDiv.removeChild(messagesDiv.lastChild);

            const markdownText = data.choices?.[0]?.message?.content || data.error || 'No response received.';
            appendMessage(markdownText, 'bot');
        } catch (error) {
            // Elimina el mensaje de "Consultando..."
            const messagesDiv = document.getElementById('chatbot-messages');
            messagesDiv.removeChild(messagesDiv.lastChild);
            appendMessage('Error: ' + error.message, 'bot');
        }
    }
</script>
