/**
 * Meditrack HMS — Email + Chat Functional Sync
 * ============================================================
 * Injected into: email.html, chat.html
 *
 * Wires both pages to MeditrackStore so that:
 *   - Emails sent/received persist across page reloads
 *   - Chat threads + messages persist across page reloads
 *   - Compose/Send buttons actually work
 *   - Inbox/Sent/Drafts/Trash folders filter correctly
 *   - Reply/Forward/Star/Delete work
 *   - Chat send button sends + thread list updates
 *   - New chat threads can be started
 *
 * Both pages share the same localStorage-backed store, so an email
 * sent from the doctor's account appears in the patient's inbox
 * (if they're the recipient).
 *
 * No external integration needed — this is a self-contained local
 * messaging system. To enable real email/SMTP, set the SMTP_*
 * env vars in Laravel .env and wire the form submit to /api/v1/messages.
 */

(function(window, document) {
    'use strict';

    if (!window.MeditrackStore) {
        console.warn('[Messaging] MeditrackStore not loaded');
        return;
    }
    const STORE = window.MeditrackStore;
    const Toast = window.Meditrack?.Toast;
    const currentUser = window.Meditrack?.getCurrentUser() || {};
    const currentUserEmail = currentUser.email || 'admin@meditrack.com';
    const currentUserName = currentUser.name || 'Meditrack User';

    const page = (window.location.pathname.split('/').pop() || '').toLowerCase();

    // ============================================================
    // EMAIL.HTML FUNCTIONALITY
    // ============================================================
    function wireEmailPage() {
        if (page !== 'email.html') return;
        console.log('[Messaging] Wiring email.html');

        // === Render email list ===
        function renderEmailList(folder = 'inbox', search = '') {
            const container = document.getElementById('emailListContainer');
            if (!container) return;

            let messages = STORE.list('messages') || [];
            // Filter by folder
            if (folder === 'inbox') {
                messages = messages.filter(m => m.folder === 'inbox' && m.to === currentUserName);
            } else if (folder === 'sent') {
                messages = messages.filter(m => m.folder === 'sent' || m.from === currentUserName);
            } else if (folder === 'starred') {
                messages = messages.filter(m => m.starred);
            } else if (folder === 'drafts') {
                messages = messages.filter(m => m.folder === 'drafts');
            } else if (folder === 'trash') {
                messages = messages.filter(m => m.folder === 'trash');
            }
            // Filter by search
            if (search) {
                const s = search.toLowerCase();
                messages = messages.filter(m =>
                    (m.subject || '').toLowerCase().includes(s) ||
                    (m.from || '').toLowerCase().includes(s) ||
                    (m.body || '').toLowerCase().includes(s)
                );
            }
            // Sort by date desc
            messages.sort((a, b) => new Date(b.date) - new Date(a.date));

            if (messages.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12 text-gray-400">
                        <svg class="mx-auto h-12 w-12 mb-3 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        <p class="text-sm">No messages in ${folder}.</p>
                    </div>`;
                return;
            }

            container.innerHTML = messages.map(m => `
                <div class="email-item p-3 border-b hover:bg-gray-50 cursor-pointer ${!m.read ? 'font-semibold bg-indigo-50/30' : ''}" data-id="${m.id}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <input type="checkbox" class="email-checkbox rounded" data-id="${m.id}">
                            ${m.starred ? '<svg class="h-4 w-4 text-amber-400 fill-current" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>' : '<svg class="h-4 w-4 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>'}
                            <div class="flex-1 min-w-0">
                                <div class="text-sm ${!m.read ? 'font-semibold' : ''}">${m.from}</div>
                                <div class="text-sm text-gray-600 truncate">${m.subject}</div>
                                <div class="text-xs text-gray-400 truncate">${(m.body || '').substring(0, 80)}...</div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-400 ml-2">${m.date || ''}</div>
                    </div>
                </div>
            `).join('');

            // Wire click handlers
            container.querySelectorAll('.email-item').forEach(item => {
                item.addEventListener('click', (e) => {
                    if (e.target.classList.contains('email-checkbox')) return;
                    const id = item.getAttribute('data-id');
                    openEmail(id);
                });
            });
        }

        // === Open email ===
        function openEmail(id) {
            const msg = STORE.get('messages', id);
            if (!msg) return;
            // Mark as read
            STORE.update('messages', id, { read: true });
            // Show in detail panel (or alert if no detail panel)
            const detailPanel = document.getElementById('emailDetailPanel') || document.getElementById('emailContent');
            if (detailPanel) {
                detailPanel.innerHTML = `
                    <div class="p-6">
                        <div class="border-b pb-4 mb-4">
                            <h2 class="text-xl font-semibold mb-2">${msg.subject}</h2>
                            <div class="text-sm text-gray-600">From: <strong>${msg.from}</strong> &lt;${msg.fromEmail}&gt;</div>
                            <div class="text-sm text-gray-600">To: <strong>${msg.to}</strong></div>
                            <div class="text-sm text-gray-400 mt-1">${msg.date}</div>
                        </div>
                        <div class="prose max-w-none text-gray-800 whitespace-pre-wrap">${msg.body}</div>
                        <div class="mt-6 flex gap-2">
                            <button class="border rounded-md px-4 py-2 text-sm hover:bg-gray-100" onclick="window._messagingReply('${msg.id}')">Reply</button>
                            <button class="border rounded-md px-4 py-2 text-sm hover:bg-gray-100" onclick="window._messagingForward('${msg.id}')">Forward</button>
                            <button class="border rounded-md px-4 py-2 text-sm hover:bg-gray-100" onclick="window._messagingStar('${msg.id}')">${msg.starred ? 'Unstar' : 'Star'}</button>
                            <button class="border border-red-300 text-red-600 rounded-md px-4 py-2 text-sm hover:bg-red-50" onclick="window._messagingDelete('${msg.id}')">Delete</button>
                        </div>
                    </div>
                `;
            } else {
                // Fallback — show in a modal
                const modal = document.createElement('div');
                modal.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;z-index:99999;';
                modal.innerHTML = `
                    <div style="background:white;border-radius:8px;max-width:600px;width:90%;max-height:80vh;overflow-y:auto;padding:24px;">
                        <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:16px;">
                            <h2 style="font-size:18px;font-weight:600;">${msg.subject}</h2>
                            <button onclick="this.closest('div[style*="position:fixed"]').remove()" style="font-size:24px;border:none;background:none;cursor:pointer;">&times;</button>
                        </div>
                        <div style="font-size:13px;color:#6b7280;margin-bottom:16px;">
                            <div>From: <strong>${msg.from}</strong> &lt;${msg.fromEmail}&gt;</div>
                            <div>To: <strong>${msg.to}</strong></div>
                            <div>${msg.date}</div>
                        </div>
                        <div style="white-space:pre-wrap;color:#374151;">${msg.body}</div>
                        <div style="margin-top:24px;display:flex;gap:8px;">
                            <button onclick="window._messagingReply('${msg.id}');this.closest('div[style*="position:fixed"]').remove()" style="padding:8px 16px;border:1px solid #d1d5db;border-radius:6px;cursor:pointer;">Reply</button>
                            <button onclick="window._messagingDelete('${msg.id}');this.closest('div[style*="position:fixed"]').remove()" style="padding:8px 16px;border:1px solid #fca5a5;color:#dc2626;border-radius:6px;cursor:pointer;">Delete</button>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
            }
            renderEmailList(currentFolder);
        }

        // Expose reply/forward/star/delete globally
        window._messagingReply = (id) => {
            const msg = STORE.get('messages', id);
            if (!msg) return;
            openComposeModal({
                to: msg.from,
                subject: 'Re: ' + msg.subject,
                body: '\n\n--- Original Message ---\nFrom: ' + msg.from + '\nDate: ' + msg.date + '\n\n' + msg.body,
            });
        };
        window._messagingForward = (id) => {
            const msg = STORE.get('messages', id);
            if (!msg) return;
            openComposeModal({
                to: '',
                subject: 'Fwd: ' + msg.subject,
                body: '\n\n--- Forwarded Message ---\nFrom: ' + msg.from + '\nDate: ' + msg.date + '\n\n' + msg.body,
            });
        };
        window._messagingStar = (id) => {
            const msg = STORE.get('messages', id);
            if (!msg) return;
            STORE.update('messages', id, { starred: !msg.starred });
            Toast?.success(msg.starred ? 'Email unstarred.' : 'Email starred.');
            renderEmailList(currentFolder);
        };
        window._messagingDelete = (id) => {
            const msg = STORE.get('messages', id);
            if (!msg) return;
            if (msg.folder === 'trash') {
                STORE.delete('messages', id);
                Toast?.success('Email permanently deleted.');
            } else {
                STORE.update('messages', id, { folder: 'trash' });
                Toast?.success('Email moved to trash.');
            }
            renderEmailList(currentFolder);
        };

        // === Compose Modal ===
        let currentFolder = 'inbox';

        function openComposeModal(prefill = {}) {
            // Use existing modal structure or create one
            let modal = document.getElementById('composeModalBackdrop');
            if (!modal) {
                const modalHtml = `<div id="composeModalBackdrop" class="modal-backdrop flex items-center justify-center z-[200]" style="position:fixed;inset:0;background:rgba(0,0,0,0.5);">
                    <div role="dialog" class="relative bg-background rounded-lg shadow-xl w-full max-w-lg mx-4 p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">Compose Email</h2>
                            <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                        </div>
                        <div class="grid gap-4">
                            <div><label class="text-sm font-medium">To</label><input id="modalTo" class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm mt-1" placeholder="recipient@meditrack.com"></div>
                            <div><label class="text-sm font-medium">Subject</label><input id="modalSubject" class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm mt-1" placeholder="Subject"></div>
                            <div><label class="text-sm font-medium">Message</label><textarea id="modalBody" class="flex w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm min-h-[150px] mt-1" placeholder="Write your message..."></textarea></div>
                        </div>
                        <div class="flex justify-end gap-2 mt-4">
                            <button id="modalCancelBtn" class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-50 text-sm">Cancel</button>
                            <button id="modalSendBtn" class="px-4 py-2 rounded-md bg-primary text-white hover:bg-primary/90 text-sm">Send</button>
                        </div>
                    </div>
                </div>`;
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                modal = document.getElementById('composeModalBackdrop');

                document.getElementById('closeModalBtn').addEventListener('click', () => modal.remove());
                document.getElementById('modalCancelBtn').addEventListener('click', () => modal.remove());
                document.getElementById('modalSendBtn').addEventListener('click', () => {
                    const to = document.getElementById('modalTo').value.trim();
                    const subject = document.getElementById('modalSubject').value.trim();
                    const body = document.getElementById('modalBody').value.trim();
                    if (!to || !subject || !body) {
                        Toast?.error('Please fill in all fields.', { title: 'Validation Error' });
                        return;
                    }
                    STORE.create('messages', {
                        from: currentUserName,
                        fromEmail: currentUserEmail,
                        to: to,
                        subject: subject,
                        body: body,
                        date: new Date().toLocaleString('en-GB', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' }),
                        read: false,
                        folder: 'sent',
                        starred: false,
                    });
                    // Also create a copy in recipient's inbox
                    STORE.create('messages', {
                        from: currentUserName,
                        fromEmail: currentUserEmail,
                        to: to,
                        subject: subject,
                        body: body,
                        date: new Date().toLocaleString('en-GB', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' }),
                        read: false,
                        folder: 'inbox',
                        starred: false,
                    });
                    Toast?.success(`Email sent to ${to}.`);
                    modal.remove();
                    renderEmailList(currentFolder);
                });
            }

            // Pre-fill
            document.getElementById('modalTo').value = prefill.to || '';
            document.getElementById('modalSubject').value = prefill.subject || '';
            document.getElementById('modalBody').value = prefill.body || '';
            modal.style.display = 'flex';
        }

        // === Wire sidebar folder buttons ===
        const folderBtns = document.querySelectorAll('[data-folder], [onclick*="folder"], .folder-item, a[href="#inbox"], a[href="#sent"], a[href="#drafts"], a[href="#starred"], a[href="#trash"]');
        folderBtns.forEach(btn => {
            const folder = btn.getAttribute('data-folder') ||
                (btn.getAttribute('href') || '').replace('#', '') ||
                btn.textContent.trim().toLowerCase();
            if (['inbox', 'sent', 'drafts', 'starred', 'trash'].includes(folder)) {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    currentFolder = folder;
                    renderEmailList(folder);
                    // Update active state
                    folderBtns.forEach(b => b.classList.remove('active', 'bg-primary', 'text-white'));
                    btn.classList.add('active', 'bg-primary', 'text-white');
                    Toast?.info(`Showing ${folder}`);
                });
            }
        });

        // === Wire Compose button ===
        const composeBtn = document.getElementById('composeBtn');
        if (composeBtn && !composeBtn.dataset.wired) {
            composeBtn.dataset.wired = '1';
            composeBtn.addEventListener('click', () => openComposeModal());
        }

        // === Wire search ===
        const searchInput = document.querySelector('input[type="search"], input[placeholder*="Search"], #emailSearch');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                renderEmailList(currentFolder, e.target.value);
            });
        }

        // === Initial render ===
        renderEmailList('inbox');

        // Listen for store changes
        STORE.onChange((entity) => {
            if (entity === 'messages') renderEmailList(currentFolder);
        });
    }

    // ============================================================
    // CHAT.HTML FUNCTIONALITY
    // ============================================================
    function wireChatPage() {
        if (page !== 'chat.html') return;
        console.log('[Messaging] Wiring chat.html');

        let currentThreadId = null;

        // === Render chat thread list ===
        function renderChatList(search = '') {
            const container = document.getElementById('chatList');
            if (!container) return;

            let threads = STORE.list('chatThreads') || [];
            if (search) {
                const s = search.toLowerCase();
                threads = threads.filter(t =>
                    (t.name || '').toLowerCase().includes(s) ||
                    (t.lastMsg || '').toLowerCase().includes(s)
                );
            }
            threads.sort((a, b) => (b.id || 0) - (a.id || 0));

            if (threads.length === 0) {
                container.innerHTML = `<div class="text-center py-12 text-gray-400 text-sm">No conversations. Start a new chat!</div>`;
                return;
            }

            container.innerHTML = threads.map(t => `
                <div class="chat-thread-item p-3 rounded-md cursor-pointer hover:bg-gray-100 ${currentThreadId == t.id ? 'bg-indigo-50' : ''}" data-thread-id="${t.id}">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-semibold shrink-0">${t.avatar || t.name.slice(0, 2).toUpperCase()}</div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-medium truncate">${t.name}</div>
                                <div class="text-xs text-gray-400">${t.time || ''}</div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="text-xs text-gray-500 truncate">${t.lastMsg || ''}</div>
                                ${t.unread > 0 ? `<span class="ml-2 inline-flex items-center justify-center h-5 min-w-[20px] px-1.5 rounded-full bg-red-500 text-white text-xs font-semibold">${t.unread}</span>` : ''}
                            </div>
                            <div class="text-xs text-gray-400">${t.role || ''} • ${t.status || ''}</div>
                        </div>
                    </div>
                </div>
            `).join('');

            container.querySelectorAll('.chat-thread-item').forEach(item => {
                item.addEventListener('click', () => {
                    currentThreadId = item.getAttribute('data-thread-id');
                    openThread(currentThreadId);
                    renderChatList(search);
                });
            });
        }

        // === Open thread ===
        function openThread(threadId) {
            const thread = STORE.get('chatThreads', threadId);
            if (!thread) return;
            // Mark as read
            STORE.update('chatThreads', threadId, { unread: 0 });

            // Update header
            const nameEl = document.getElementById('chatName');
            const statusEl = document.getElementById('chatStatus');
            const roleEl = document.getElementById('chatRole');
            const avatarEl = document.getElementById('chatAvatar');
            if (nameEl) nameEl.textContent = thread.name;
            if (statusEl) {
                statusEl.textContent = thread.status === 'online' ? 'Online' : (thread.status || 'Offline');
                statusEl.className = 'text-xs ' + (thread.status === 'online' ? 'text-green-500' : 'text-gray-400');
            }
            if (roleEl) roleEl.textContent = thread.role || '';
            if (avatarEl) avatarEl.textContent = thread.avatar || thread.name.slice(0, 2).toUpperCase();

            // Render messages
            const messages = STORE.get('chatMessages', threadId) || [];
            const msgArea = document.querySelector('.flex-1.overflow-y-auto, #messageArea, [class*="message"]');
            // Try multiple selectors for the message area
            let msgContainer = document.getElementById('chatMessagesContainer');
            if (!msgContainer) {
                // Find the main chat area between header and input
                const input = document.getElementById('messageInput');
                if (input) {
                    msgContainer = input.closest('.flex, .grid')?.previousElementSibling;
                    if (!msgContainer) {
                        // Create one
                        msgContainer = document.createElement('div');
                        msgContainer.id = 'chatMessagesContainer';
                        msgContainer.style.cssText = 'flex:1;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:8px;';
                        input.closest('.flex, .grid')?.parentNode.insertBefore(msgContainer, input.closest('.flex, .grid'));
                    }
                }
            }

            if (msgContainer) {
                msgContainer.innerHTML = messages.map(m => {
                    const isMe = m.sender === 'me';
                    return `
                        <div style="display:flex;justify-content:${isMe ? 'flex-end' : 'flex-start'};margin-bottom:8px;">
                            <div style="max-width:70%;padding:8px 12px;border-radius:8px;background:${isMe ? '#4f46e5' : '#f3f4f6'};color:${isMe ? 'white' : '#1f2937'};font-size:14px;">
                                <div>${m.text}</div>
                                <div style="font-size:10px;opacity:0.7;margin-top:2px;text-align:right;">${m.time || ''}</div>
                            </div>
                        </div>
                    `;
                }).join('');
                // Scroll to bottom
                msgContainer.scrollTop = msgContainer.scrollHeight;
            }

            // Enable input + send button
            const input = document.getElementById('messageInput');
            const sendBtn = document.getElementById('sendBtn');
            if (input) input.disabled = false;
            if (sendBtn) sendBtn.disabled = false;
        }

        // === Send message ===
        function sendMessage() {
            const input = document.getElementById('messageInput');
            if (!input || !currentThreadId) return;
            const text = input.value.trim();
            if (!text) return;

            const time = new Date().toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });

            // Append to messages for this thread
            const messages = STORE.get('chatMessages', currentThreadId) || [];
            messages.push({ sender: 'me', text, time });
            STORE.update('chatMessages', currentThreadId, messages);

            // Update thread's last message
            STORE.update('chatThreads', currentThreadId, {
                lastMsg: text,
                time: 'Now',
            });

            input.value = '';
            Toast?.success('Message sent.');
            openThread(currentThreadId);
            renderChatList();

            // Simulate reply after 1-3 seconds
            const thread = STORE.get('chatThreads', currentThreadId);
            if (thread) {
                setTimeout(() => {
                    const replies = [
                        'Got it, thanks!',
                        'Understood. I will check on that.',
                        'Sure, let me get back to you shortly.',
                        'Noted.',
                        'Thank you for the update.',
                        'I will review and respond soon.',
                        'Acknowledged.',
                    ];
                    const reply = replies[Math.floor(Math.random() * replies.length)];
                    const msgs = STORE.get('chatMessages', currentThreadId) || [];
                    msgs.push({ sender: 'them', text: reply, time: new Date().toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' }) });
                    STORE.update('chatMessages', currentThreadId, msgs);
                    STORE.update('chatThreads', currentThreadId, { lastMsg: reply, time: 'Now', unread: 0 });
                    if (currentThreadId) openThread(currentThreadId);
                    renderChatList();
                }, 1000 + Math.random() * 2000);
            }
        }

        // === Wire send button + Enter key ===
        const sendBtn = document.getElementById('sendBtn');
        const msgInput = document.getElementById('messageInput');
        if (sendBtn && !sendBtn.dataset.wired) {
            sendBtn.dataset.wired = '1';
            sendBtn.addEventListener('click', sendMessage);
        }
        if (msgInput && !msgInput.dataset.wired) {
            msgInput.dataset.wired = '1';
            msgInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
        }

        // === Wire new chat button ===
        const newChatBtn = document.querySelector('[data-action="new-chat"], #newChatBtn, button[onclick*="newChat"]');
        if (newChatBtn && !newChatBtn.dataset.wired) {
            newChatBtn.dataset.wired = '1';
            newChatBtn.addEventListener('click', () => {
                const name = prompt('Enter contact name:');
                if (!name) return;
                const role = prompt('Role (e.g., Doctor, Nurse):') || 'Contact';
                const newThread = STORE.create('chatThreads', {
                    name, role, avatar: name.slice(0, 2).toUpperCase(),
                    unread: 0, lastMsg: 'New conversation', time: 'Now',
                    status: 'online', blocked: false, group: false,
                });
                // Initialize empty messages array for this thread
                const allMsgs = STORE.list('chatMessages') || {};
                allMsgs[newThread.id] = [];
                localStorage.setItem('meditrack_chatMessages', JSON.stringify(allMsgs));
                Toast?.success(`New chat started with ${name}.`);
                renderChatList();
                openThread(newThread.id);
            });
        }

        // === Wire search ===
        const searchInput = document.querySelector('#chatSearch, input[placeholder*="Search"]');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => renderChatList(e.target.value));
        }

        // === Initial render ===
        renderChatList();
        // Auto-open first thread
        const threads = STORE.list('chatThreads') || [];
        if (threads.length > 0) {
            openThread(threads[0].id);
        }

        // Listen for store changes
        STORE.onChange((entity) => {
            if (entity === 'chatThreads' || entity === 'chatMessages') {
                renderChatList();
                if (currentThreadId) openThread(currentThreadId);
            }
        });
    }

    // ============================================================
    // INIT
    // ============================================================
    function init() {
        wireEmailPage();
        wireChatPage();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    // Re-run after a delay (pages render dynamically)
    setTimeout(init, 500);
    setTimeout(init, 1500);

})(window, document);
