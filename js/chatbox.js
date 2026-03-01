// Chatbox functionality
const chatboxToggle = document.getElementById('chatbox-toggle');
const chatboxWindow = document.getElementById('chatbox-window');
const closeChat = document.getElementById('close-chat');
const chatInput = document.getElementById('chat-input');
const sendMessageBtn = document.getElementById('send-message');
const chatboxBody = document.getElementById('chatbox-body');
const quickQuestions = document.getElementById('quickQuestions');
const typingIndicator = document.getElementById('typingIndicator');

// Question bank with predefined answers (MIS À JOUR AVEC LES INFOS DU FOOTER)
const questionBank = {
    appointment: {
        question: "I'd like to book an appointment",
        answer: "📅 **Book an appointment**\n\nYou can schedule a consultation using the form above, or click here to book directly:\n\n👉 [Book Online Appointment](#appointment-form)\n\nOr call us at **214-4607** during office hours and we'll help you schedule a meeting."
    },
    hours: {
        question: "What are your office hours?",
        answer: "⏰ **Office Hours**\n\n• Monday - Friday: 9:00 AM - 5:00 PM\n• Saturday: 9:00 AM - 1:00 PM\n• Sunday: Closed\n\n_We also offer emergency consultations outside these hours._"
    },
    phone: {
        question: "I need your phone number",
        answer: "📞 **Contact us by phone**\n\nMain line: **214-4607**\nEmergency: `+230 5252 5252`\n\nWe're available during office hours for immediate assistance."
    },
    email: {
        question: "What's your email address?",
        answer: "📧 **Email us**\n\nGeneral inquiries: **LawFirmPrecision@outlook.com**\nCareers: `careers@precisionlaw.com`\n\nWe typically respond within 24 hours."
    },
    location: {
        question: "Where are you located?",
        answer: "📍 **Our Location**\n\n**Precision Law Firm**\n7th floor, Astor Court\nGeorges Guibert Street, Port Louis\n\n🔍 **View on Google Maps:**\nhttps://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3745.23474114697!2d57.50536630000003!3d-20.16594940000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x217c5055b4671f75%3A0xc02adf055f55008a!2sAstor%20Court%20Building!5e0!3m2!1sfr!2smu!4v1772376043792!5m2!1sfr!2smu\n\n_Parking available nearby_"
    },
    career: {
        question: "I'm interested in career opportunities",
        answer: "💼 **Careers at Precision Law**\n\nWe're currently hiring:\n• Junior Associates\n• Legal Interns\n• Paralegals\n\nSend your CV to: `careers@precisionlaw.com`\n\nOr visit our [Careers Page](#) for more details."
    },
    services: {
        question: "What services do you offer?",
        answer: "⚖️ **Our Legal Services**\n\n• Corporate Law\n• Family Law\n• Criminal Defense\n• Real Estate\n• Immigration\n• Intellectual Property\n\nEach consultation is tailored to your specific needs."
    },
    consultation: {
        question: "How much does a consultation cost?",
        answer: "💰 **Consultation Fees**\n\n• Initial consultation (30 min): **Free**\n• Standard consultation: **Rs 2,500/hour**\n• Emergency consultation: **Rs 5,000/hour**\n\n_Payment plans available for ongoing cases_"
    }
};

// Toggle chat window
chatboxToggle.addEventListener('click', () => {
    chatboxWindow.classList.toggle('active');
    const badge = document.querySelector('.notification-badge');
    if (badge) {
        badge.style.display = 'none';
    }

    // Scroll to bottom when opening
    if (chatboxWindow.classList.contains('active')) {
        chatboxBody.scrollTop = chatboxBody.scrollHeight;
    }
});

// Close chat
closeChat.addEventListener('click', () => {
    chatboxWindow.classList.remove('active');
});

// Send message on button click
sendMessageBtn.addEventListener('click', sendMessage);

// Send message on Enter key
chatInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
    }
});

// Quick questions buttons
document.querySelectorAll('.question-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const questionKey = this.dataset.question;
        if (questionBank[questionKey]) {
            // Add user message
            addMessage(questionBank[questionKey].question, 'user');

            // Show typing indicator
            showTypingIndicator();

            // Hide quick questions after use
            quickQuestions.style.display = 'none';

            // Simulate bot typing and respond
            setTimeout(() => {
                hideTypingIndicator();
                addMessage(questionBank[questionKey].answer, 'bot');

                // Show quick questions again after response
                setTimeout(() => {
                    quickQuestions.style.display = 'block';
                }, 1000);
            }, 1500);
        }
    });
});

// Send message function
function sendMessage() {
    const message = chatInput.value.trim();
    if (!message) return;

    // Add user message
    addMessage(message, 'user');
    chatInput.value = '';

    // Hide quick questions
    quickQuestions.style.display = 'none';

    // Show typing indicator
    showTypingIndicator();

    // Simulate bot response
    setTimeout(() => {
        hideTypingIndicator();
        const botResponse = getBotResponse(message);
        addMessage(botResponse, 'bot');

        // Show quick questions again after response
        setTimeout(() => {
            quickQuestions.style.display = 'block';
        }, 1000);
    }, 1500);
}

// Add message to chat
function addMessage(text, sender) {
    const msg = document.createElement('div');
    msg.className = `message ${sender}`;

    // Format message content (convert markdown-style formatting)
    let formattedText = text
        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
        .replace(/\*(.*?)\*/g, '<em>$1</em>')
        .replace(/`(.*?)`/g, '<code>$1</code>')
        .replace(/\n/g, '<br>');

    // Détecter et convertir les URLs en liens cliquables
    const urlRegex = /(https?:\/\/[^\s<]+)/g;
    formattedText = formattedText.replace(urlRegex, function (url) {
        // Pour les liens Google Maps, on crée un lien cliquable
        if (url.includes('google.com/maps')) {
            return `<a href="${url}" target="_blank" class="map-link" style="color: #1C4D8D; text-decoration: underline; word-break: break-all;">📍 Voir sur Google Maps</a>`;
        }
        return `<a href="${url}" target="_blank" style="color: #1C4D8D; text-decoration: underline; word-break: break-all;">${url}</a>`;
    });

    msg.innerHTML = `
        <div class="message-avatar">
            <i class="fas ${sender === 'user' ? 'fa-user' : 'fa-robot'}"></i>
        </div>
        <div class="message-wrapper">
            <div class="message-content">${formattedText}</div>
            <div class="message-time">${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</div>
        </div>
    `;

    chatboxBody.appendChild(msg);
    chatboxBody.scrollTop = chatboxBody.scrollHeight;
}

// Show typing indicator
function showTypingIndicator() {
    typingIndicator.classList.add('active');
    chatboxBody.scrollTop = chatboxBody.scrollHeight;
}

// Hide typing indicator
function hideTypingIndicator() {
    typingIndicator.classList.remove('active');
}

// Get bot response based on user input (MIS À JOUR AVEC LES INFOS DU FOOTER)
function getBotResponse(message) {
    const lower = message.toLowerCase();

    // Check for keywords in the message
    if (lower.includes('appointment') || lower.includes('book') || lower.includes('schedule')) {
        return questionBank.appointment.answer;
    }
    if (lower.includes('hour') || lower.includes('time') || lower.includes('open')) {
        return questionBank.hours.answer;
    }
    if (lower.includes('phone') || lower.includes('call') || lower.includes('contact')) {
        return questionBank.phone.answer;
    }
    if (lower.includes('email') || lower.includes('mail')) {
        return questionBank.email.answer;
    }
    if (lower.includes('location') || lower.includes('address') || lower.includes('where')) {
        return questionBank.location.answer;
    }
    if (lower.includes('career') || lower.includes('job') || lower.includes('work') || lower.includes('hire')) {
        return questionBank.career.answer;
    }
    if (lower.includes('service') || lower.includes('practice') || lower.includes('area')) {
        return questionBank.services.answer;
    }
    if (lower.includes('cost') || lower.includes('price') || lower.includes('fee') || lower.includes('pay')) {
        return questionBank.consultation.answer;
    }
    if (lower.includes('hello') || lower.includes('hi') || lower.includes('hey')) {
        return "👋 Hello! I'm your legal assistant. How can I assist you with your legal matters today? Feel free to ask about our services, book an appointment, or use the quick questions above.";
    }
    if (lower.includes('thank')) {
        return "You're welcome! 😊 Is there anything else I can help you with?";
    }

    // Default response for unrecognized queries (MIS À JOUR)
    return "Thank you for your message. For specific legal inquiries, I'd recommend:\n\n" +
        "📞 **Call us**: `214-4607`\n" +
        "📧 **Email**: `LawFirmPrecision@outlook.com`\n" +
        "📍 **Visit us**: 7th floor, Astor Court, Georges Guibert Street, Port Louis\n\n" +
        "📅 **Book an appointment** using the form above\n\n" +
        "_A representative will get back to you shortly._";
}

// Initial greeting with slight delay for effect
setTimeout(() => {
    if (chatboxBody.children.length === 1) { // Only if only the initial message exists
        const welcomeMessage = document.querySelector('.message.bot .message-content');
        if (welcomeMessage) {
            welcomeMessage.innerHTML = "👋 Hello! I'm your legal assistant from **Precision Law Firm**. How can I help you today? You can ask about:\n\n" +
                "• 📅 Appointments\n" +
                "• ⏰ Office hours\n" +
                "• 📞 Contact (214-4607)\n" +
                "• 📧 Email (LawFirmPrecision@outlook.com)\n" +
                "• 📍 Location (Astor Court)\n" +
                "• ⚖️ Our services\n" +
                "• 💼 Careers\n\n" +
                "Or click any of the questions below!";
        }
    }
}, 500);