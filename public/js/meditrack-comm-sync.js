/**
 * Meditrack HMS — Communication Pages Sync
 * ============================================================
 * Wires 5 communication pages to read real data from MeditrackStore:
 *
 *   - notifications.html → reads from meditrack_notifications (store)
 *   - calendar.html      → reads from appointments + calendar_events
 *   - task.html          → functional CRUD for tasks (meditrack_tasks)
 *   - contacts.html      → reads from staff + patients + suppliers
 *   - support.html       → functional ticket system (meditrack_support_tickets)
 *
 * Each page gets its data rendered dynamically instead of showing
 * static/dummy content.
 */

(function(window, document) {
    'use strict';

    if (!window.MeditrackStore) return;
    const STORE = window.MeditrackStore;
    const Toast = window.Meditrack?.Toast;

    const page = (window.location.pathname.split('/').pop() || '').toLowerCase();

    // ============================================================
    // NOTIFICATIONS.HTML — read from meditrack_notifications
    // ============================================================
    function wireNotificationsPage() {
        if (page !== 'notifications.html') return;
        console.log('[CommSync] Wiring notifications.html');

        function renderNotifications() {
            const notifs = STORE.list('notifications') || [];
            // Sort by created_at desc
            notifs.sort((a, b) => new Date(b.created_at || 0) - new Date(a.created_at || 0));

            // Find the notification list container
            let container = document.querySelector('.notification-list, #notificationList, [class*="notification"][class*="container"], .space-y-3, .divide-y');
            if (!container) {
                // Create one
                const main = document.querySelector('main, .main, [class*="main"]') || document.body;
                container = document.createElement('div');
                container.className = 'space-y-3';
                container.id = 'notificationList';
                main.appendChild(container);
            }

            if (notifs.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12 text-gray-400">
                        <svg class="mx-auto h-12 w-12 mb-3 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                        <p class="text-sm">No notifications yet. You're all caught up!</p>
                    </div>`;
                return;
            }

            container.innerHTML = notifs.map(n => {
                const isUnread = !n.is_read;
                const iconMap = {
                    appointment: '📅', billing: '💰', lab: '🔬', system: '⚙️',
                    message: '💬', alert: '🚨', prescription: '💊',
                };
                const icon = iconMap[n.category] || '🔔';
                const time = n.created_at ? new Date(n.created_at).toLocaleString('en-GB', { day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit' }) : '';

                return `
                    <div class="notification-item flex items-start gap-3 p-3 rounded-lg border ${isUnread ? 'bg-indigo-50/30 border-indigo-200' : 'bg-white border-gray-200'}" data-id="${n.id}">
                        <div class="text-2xl">${icon}</div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-medium ${isUnread ? 'text-indigo-900' : 'text-gray-900'}">${n.title || 'Notification'}</div>
                                ${isUnread ? '<span class="h-2 w-2 rounded-full bg-indigo-500"></span>' : ''}
                            </div>
                            <div class="text-sm text-gray-500 mt-1">${n.message || ''}</div>
                            <div class="text-xs text-gray-400 mt-1">${time}</div>
                        </div>
                        ${!isUnread ? '' : `<button class="mark-read-btn text-xs text-indigo-600 hover:text-indigo-900" data-id="${n.id}">Mark read</button>`}
                    </div>
                `;
            }).join('');

            // Wire mark-read buttons
            container.querySelectorAll('.mark-read-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const id = btn.getAttribute('data-id');
                    STORE.update('notifications', id, { is_read: true });
                    Toast?.success('Notification marked as read.');
                    renderNotifications();
                });
            });

            // Wire "mark all read" button if present
            const markAllBtn = document.querySelector('[data-action="mark-all-read"], #markAllReadBtn');
            if (markAllBtn && !markAllBtn.dataset.wired) {
                markAllBtn.dataset.wired = '1';
                markAllBtn.addEventListener('click', () => {
                    notifs.forEach(n => { if (!n.is_read) STORE.update('notifications', n.id, { is_read: true }); });
                    Toast?.success('All notifications marked as read.');
                    renderNotifications();
                });
            }

            // Update unread count badge
            const unreadCount = notifs.filter(n => !n.is_read).length;
            const badge = document.querySelector('.notification-badge, [class*="unread-count"]');
            if (badge) badge.textContent = unreadCount;
        }

        renderNotifications();
        STORE.onChange((entity) => { if (entity === 'notifications') renderNotifications(); });
    }

    // ============================================================
    // CALENDAR.HTML — sync with appointments store
    // ============================================================
    function wireCalendarPage() {
        if (page !== 'calendar.html') return;
        console.log('[CommSync] Wiring calendar.html');

        // Seed calendar events from appointments if empty
        const events = STORE.list('calendar_events') || [];
        if (events.length === 0) {
            const appts = STORE.list('appointments') || [];
            appts.forEach(a => {
                STORE.create('calendar_events', {
                    title: `Appointment: ${a.patient} — ${a.doctor}`,
                    category: 'appointment',
                    date: a.date,
                    start_time: a.time || '09:00',
                    end_time: '10:00',
                    location: 'Hospital',
                    description: `Type: ${a.type}, Status: ${a.status}`,
                });
            });
        }

        // Render events in any existing calendar UI
        function renderEvents() {
            const events = STORE.list('calendar_events') || [];
            const eventList = document.querySelector('.event-list, #eventList, [class*="event"][class*="list"]');
            if (!eventList) return;

            if (events.length === 0) {
                eventList.innerHTML = '<div class="text-center text-gray-400 py-8 text-sm">No events scheduled.</div>';
                return;
            }

            events.sort((a, b) => new Date(a.date || 0) - new Date(b.date || 0));
            eventList.innerHTML = events.map(e => {
                const catColors = {
                    appointment: 'bg-blue-100 text-blue-700',
                    meeting: 'bg-purple-100 text-purple-700',
                    task: 'bg-amber-100 text-amber-700',
                    reminder: 'bg-green-100 text-green-700',
                    personal: 'bg-pink-100 text-pink-700',
                    holiday: 'bg-red-100 text-red-700',
                };
                const colorClass = catColors[e.category] || 'bg-gray-100 text-gray-700';
                return `
                    <div class="event-item p-3 rounded-lg border hover:bg-gray-50 cursor-pointer" data-id="${e.id}">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold ${colorClass}">${e.category || 'event'}</span>
                            <span class="text-sm font-medium">${e.title}</span>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">${e.date || ''} ${e.start_time || ''} ${e.location ? '• ' + e.location : ''}</div>
                        ${e.description ? `<div class="text-xs text-gray-400 mt-1">${e.description}</div>` : ''}
                    </div>
                `;
            }).join('');
        }

        renderEvents();
        STORE.onChange((entity) => { if (entity === 'calendar_events') renderEvents(); });
    }

    // ============================================================
    // TASK.HTML — functional CRUD
    // ============================================================
    function wireTaskPage() {
        if (page !== 'task.html') return;
        console.log('[CommSync] Wiring task.html');

        function renderTasks() {
            let tasks = STORE.list('meditrack_tasks') || [];
            const taskList = document.querySelector('.task-list, #taskList, [class*="task"][class*="list"], .space-y-2');
            if (!taskList) return;

            if (tasks.length === 0) {
                // Seed with sample tasks
                tasks = [
                    { id: 1, title: 'Review lab results for P-10001', priority: 'high', status: 'pending', due: new Date().toISOString().slice(0, 10), assignee: 'Dr. Nakato Sarah' },
                    { id: 2, title: 'Prepare monthly financial report', priority: 'medium', status: 'in-progress', due: new Date(Date.now() + 86400000).toISOString().slice(0, 10), assignee: 'Nabisere Patricia' },
                    { id: 3, title: 'Order surgical gloves (low stock)', priority: 'high', status: 'pending', due: new Date().toISOString().slice(0, 10), assignee: 'Byaruhanga Robert' },
                    { id: 4, title: 'Schedule staff vaccination drive', priority: 'low', status: 'completed', due: new Date(Date.now() - 86400000).toISOString().slice(0, 10), assignee: 'Nalwoga Sarah' },
                ];
                tasks.forEach(t => STORE.create('meditrack_tasks', t));
            }

            tasks.sort((a, b) => {
                const statusOrder = { pending: 0, 'in-progress': 1, completed: 2 };
                return (statusOrder[a.status] || 0) - (statusOrder[b.status] || 0);
            });

            const priorityColors = { high: 'text-red-600', medium: 'text-amber-600', low: 'text-green-600' };
            const statusBadges = {
                pending: '<span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Pending</span>',
                'in-progress': '<span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold bg-blue-100 text-blue-700">In Progress</span>',
                completed: '<span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-700">Completed</span>',
            };

            taskList.innerHTML = tasks.map(t => `
                <div class="task-item flex items-center gap-3 p-3 rounded-lg border hover:bg-gray-50" data-id="${t.id}">
                    <input type="checkbox" class="task-checkbox rounded" data-id="${t.id}" ${t.status === 'completed' ? 'checked' : ''}>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium ${t.status === 'completed' ? 'line-through text-gray-400' : 'text-gray-900'}">${t.title}</div>
                        <div class="flex items-center gap-3 mt-1">
                            <span class="text-xs ${priorityColors[t.priority] || 'text-gray-500'}">${t.priority || 'low'}</span>
                            <span class="text-xs text-gray-400">Due: ${t.due || '—'}</span>
                            <span class="text-xs text-gray-400">${t.assignee || ''}</span>
                        </div>
                    </div>
                    ${statusBadges[t.status] || statusBadges.pending}
                    <button class="task-delete text-red-500 hover:text-red-700 text-sm" data-id="${t.id}">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    </button>
                </div>
            `).join('');

            // Wire checkboxes
            taskList.querySelectorAll('.task-checkbox').forEach(cb => {
                cb.addEventListener('change', () => {
                    const id = cb.getAttribute('data-id');
                    const newStatus = cb.checked ? 'completed' : 'pending';
                    STORE.update('meditrack_tasks', id, { status: newStatus });
                    Toast?.success(newStatus === 'completed' ? 'Task completed!' : 'Task reopened.');
                    renderTasks();
                });
            });

            // Wire delete buttons
            taskList.querySelectorAll('.task-delete').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const id = btn.getAttribute('data-id');
                    if (window.Meditrack?.confirm) {
                        window.Meditrack.confirm('Delete this task?', () => {
                            STORE.delete('meditrack_tasks', id);
                            Toast?.success('Task deleted.');
                            renderTasks();
                        }, { danger: true, title: 'Delete Task', okText: 'Delete' });
                    }
                });
            });
        }

        // Wire add task form
        const addTaskForm = document.querySelector('form#addTaskForm, form[data-entity="tasks"]');
        if (addTaskForm && !addTaskForm.dataset.wired) {
            addTaskForm.dataset.wired = '1';
            addTaskForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const fd = new FormData(addTaskForm);
                const title = fd.get('title') || fd.get('task') || fd.get('name');
                if (!title) { Toast?.error('Task title is required.'); return; }
                STORE.create('meditrack_tasks', {
                    title,
                    priority: fd.get('priority') || 'medium',
                    status: 'pending',
                    due: fd.get('due') || fd.get('due_date') || new Date().toISOString().slice(0, 10),
                    assignee: fd.get('assignee') || window.Meditrack?.getCurrentUser()?.name || 'Unassigned',
                });
                Toast?.success('Task added.');
                addTaskForm.reset();
                renderTasks();
            });
        }

        renderTasks();
        STORE.onChange((entity) => { if (entity === 'meditrack_tasks') renderTasks(); });
    }

    // ============================================================
    // CONTACTS.HTML — read from staff + patients + suppliers
    // ============================================================
    function wireContactsPage() {
        if (page !== 'contacts.html') return;
        console.log('[CommSync] Wiring contacts.html');

        function renderContacts() {
            const staff = STORE.list('staff') || [];
            const patients = STORE.list('patients') || [];
            const suppliers = STORE.list('suppliers') || [];

            // Combine all contacts
            const contacts = [
                ...staff.map(s => ({ name: s.name, role: s.role, email: s.email, phone: s.phone, type: 'Staff', department: s.department })),
                ...patients.map(p => ({ name: p.name, role: 'Patient', email: p.email, phone: p.phone, type: 'Patient', department: p.condition })),
                ...suppliers.map(s => ({ name: s.name, role: 'Supplier', email: s.email, phone: s.phone, type: 'Supplier', department: s.category })),
            ];

            const contactList = document.querySelector('.contact-list, #contactList, [class*="contact"][class*="list"], tbody');
            if (!contactList) return;

            if (contacts.length === 0) {
                contactList.innerHTML = '<tr><td colspan="5" class="text-center text-gray-400 py-8">No contacts found.</td></tr>';
                return;
            }

            // Check if it's a table body
            if (contactList.tagName === 'TBODY') {
                contactList.innerHTML = contacts.map(c => `
                    <tr>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-semibold overflow-hidden">
                                    <img src="user.png" alt="${c.name}" style="width:100%;height:100%;object-fit:cover;border-radius:inherit">
                                </div>
                                <div class="text-sm font-medium text-gray-900">${c.name || '—'}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">${c.role || '—'}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">${c.email || '—'}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">${c.phone || '—'}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold ${c.type === 'Staff' ? 'bg-blue-100 text-blue-700' : c.type === 'Patient' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'}">${c.type}</span>
                        </td>
                    </tr>
                `).join('');
            } else {
                // Card layout
                contactList.innerHTML = contacts.map(c => `
                    <div class="contact-card flex items-center gap-3 p-3 rounded-lg border hover:bg-gray-50">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 overflow-hidden">
                            <img src="user.png" alt="${c.name}" style="width:100%;height:100%;object-fit:cover">
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium text-gray-900">${c.name || '—'}</div>
                            <div class="text-xs text-gray-500">${c.role || ''} ${c.department ? '• ' + c.department : ''}</div>
                        </div>
                        <div class="text-xs text-gray-400">${c.phone || c.email || ''}</div>
                    </div>
                `).join('');
            }
        }

        renderContacts();
    }

    // ============================================================
    // SUPPORT.HTML — functional ticket system
    // ============================================================
    function wireSupportPage() {
        if (page !== 'support.html') return;
        console.log('[CommSync] Wiring support.html');

        // Seed sample tickets if empty
        let tickets = STORE.list('meditrack_support_tickets') || [];
        if (tickets.length === 0) {
            const sampleTickets = [
                { id: 1, subject: 'Cannot access patient records', category: 'Technical', priority: 'High', status: 'Open', description: 'Getting 403 error when trying to view patient P-10001.', created_at: new Date(Date.now() - 86400000).toISOString(), user: 'Dr. Nakato Sarah' },
                { id: 2, subject: 'Request for new pharmacy module', category: 'Feature Request', priority: 'Medium', status: 'In Progress', description: 'We need a way to track expired medications automatically.', created_at: new Date(Date.now() - 172800000).toISOString(), user: 'Ssemwogerere David' },
                { id: 3, subject: 'Invoice template customization', category: 'Customization', priority: 'Low', status: 'Resolved', description: 'Want to add hospital logo to invoice PDFs.', created_at: new Date(Date.now() - 259200000).toISOString(), user: 'Nabisere Patricia' },
            ];
            sampleTickets.forEach(t => STORE.create('meditrack_support_tickets', t));
        }

        function renderTickets() {
            const tickets = STORE.list('meditrack_support_tickets') || [];
            const ticketList = document.querySelector('.ticket-list, #ticketList, [class*="ticket"][class*="list"], tbody');
            if (!ticketList) return;

            tickets.sort((a, b) => new Date(b.created_at || 0) - new Date(a.created_at || 0));

            const statusColors = {
                Open: 'bg-blue-100 text-blue-700',
                'In Progress': 'bg-amber-100 text-amber-700',
                Resolved: 'bg-green-100 text-green-700',
                Closed: 'bg-gray-100 text-gray-700',
            };
            const priorityColors = { High: 'text-red-600', Medium: 'text-amber-600', Low: 'text-green-600' };

            if (ticketList.tagName === 'TBODY') {
                ticketList.innerHTML = tickets.map(t => `
                    <tr data-id="${t.id}">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">#${t.id}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">${t.subject}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">${t.category}</td>
                        <td class="px-4 py-3 text-sm ${priorityColors[t.priority] || 'text-gray-500'}">${t.priority}</td>
                        <td class="px-4 py-3"><span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold ${statusColors[t.status] || statusColors.Open}">${t.status}</span></td>
                        <td class="px-4 py-3 text-sm text-gray-500">${t.user || '—'}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">${t.created_at ? new Date(t.created_at).toLocaleDateString('en-GB') : '—'}</td>
                        <td class="px-4 py-3 text-right">
                            <button class="action-menu-btn w-8 h-8 rounded-full hover:bg-gray-200 flex items-center justify-center ml-auto transition-colors" data-id="${t.id}" data-entity="support_tickets">
                                <svg class="h-4 w-4 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                            </button>
                        </td>
                    </tr>
                `).join('');
            } else {
                ticketList.innerHTML = tickets.map(t => `
                    <div class="ticket-card p-4 rounded-lg border hover:bg-gray-50 cursor-pointer" data-id="${t.id}">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-900">#${t.id} ${t.subject}</div>
                                <div class="text-xs text-gray-500 mt-1">${t.category} • ${t.user || '—'} • ${t.created_at ? new Date(t.created_at).toLocaleDateString('en-GB') : ''}</div>
                            </div>
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold ${statusColors[t.status] || statusColors.Open}">${t.status}</span>
                        </div>
                    </div>
                `).join('');
            }
        }

        // Wire new ticket form
        const ticketForm = document.querySelector('form#newTicketForm, form[data-entity="support_tickets"]');
        if (ticketForm && !ticketForm.dataset.wired) {
            ticketForm.dataset.wired = '1';
            ticketForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const fd = new FormData(ticketForm);
                const subject = fd.get('subject') || fd.get('title');
                if (!subject) { Toast?.error('Subject is required.'); return; }
                STORE.create('meditrack_support_tickets', {
                    subject,
                    category: fd.get('category') || 'General',
                    priority: fd.get('priority') || 'Medium',
                    status: 'Open',
                    description: fd.get('description') || fd.get('message') || '',
                    created_at: new Date().toISOString(),
                    user: window.Meditrack?.getCurrentUser()?.name || 'Unknown',
                });
                Toast?.success('Support ticket created.');
                ticketForm.reset();
                renderTickets();
            });
        }

        renderTickets();
        STORE.onChange((entity) => { if (entity === 'meditrack_support_tickets') renderTickets(); });
    }

    // ============================================================
    // INIT
    // ============================================================
    function init() {
        wireNotificationsPage();
        wireCalendarPage();
        wireTaskPage();
        wireContactsPage();
        wireSupportPage();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    setTimeout(init, 1500);

})(window, document);
