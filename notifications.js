/**
 * Modern Notification System
 * Features: Toast notifications, types (info, success, warning, error), clean animations.
 * No external frameworks required.
 */

const NotificationSystem = (() => {
    // SVGs for different notification types for a premium look
    const icons = {
        info: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>`,
        success: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>`,
        warning: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>`,
        error: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>`
    };

    /**
     * Ensure the container exists in the DOM.
     * Notifications should render inside a container with id "notification-container"
     */
    function getContainer() {
        let container = document.getElementById('notification-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'notification-container';
            document.body.appendChild(container);
        }
        return container;
    }

    /**
     * Create a single notification element
     * @param {Object} notif 
     * @param {string} notif.title - Notification title (optional)
     * @param {string} notif.message - Notification message
     * @param {string} notif.type - 'info', 'success', 'warning', 'error'
     * @param {number} notif.duration - time in ms before auto-closing (0 for no auto-close)
     */
    function createNotificationElement(notif) {
        const { title, message, type = 'info', duration = 5000 } = notif;

        const el = document.createElement('div');
        el.className = `sys-notification sys-notification-${type}`;

        const iconHtml = icons[type] ? `<div class="sys-notification-icon">${icons[type]}</div>` : '';

        // Use proper DOM node creation to prevent XSS (production-ready)
        let textContentWrapper = false;
        let titleEl, messageEl;

        if (title) {
            textContentWrapper = true;
            titleEl = document.createElement('div');
            titleEl.className = 'sys-notification-title';
            titleEl.textContent = title;
        }

        if (message) {
            textContentWrapper = true;
            messageEl = document.createElement('div');
            messageEl.className = 'sys-notification-message';
            messageEl.textContent = message;
        }

        el.innerHTML = `
            <div class="sys-notification-content">
                ${iconHtml}
                <div class="sys-notification-text"></div>
            </div>
            <button class="sys-notification-close" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        `;

        if (textContentWrapper) {
            const textContainer = el.querySelector('.sys-notification-text');
            if (titleEl) textContainer.appendChild(titleEl);
            if (messageEl) textContainer.appendChild(messageEl);
        } else {
            const textContainer = el.querySelector('.sys-notification-text');
            if (textContainer) textContainer.remove();
        }

        // Setup close btn
        const closeBtn = el.querySelector('.sys-notification-close');
        closeBtn.addEventListener('click', () => {
            closeNotification(el);
        });

        // Auto close
        if (duration > 0) {
            setTimeout(() => {
                closeNotification(el);
            }, duration);
        }

        return el;
    }

    /**
     * Closes and removes a notification instance with animation
     * @param {HTMLElement} el 
     */
    function closeNotification(el) {
        if (!el || el.classList.contains('hide')) return;

        // Setup animation classes
        el.classList.remove('show');
        el.classList.add('hide');

        // Remove from DOM after CSS transition ends (approx 400ms)
        setTimeout(() => {
            if (el.parentNode) {
                el.parentNode.removeChild(el);
            }
        }, 400);
    }

    /**
     * Public method to render notifications dynamically from a JS array
     * @param {Array|Object} notifications - Array of notification objects or a single valid object
     */
    function show(notifications) {
        // Normalize single object to array for uniform processing
        if (!Array.isArray(notifications) && typeof notifications === 'object') {
            notifications = [notifications];
        }

        if (!Array.isArray(notifications)) {
            console.error('NotificationSystem.show expects an array of notification objects or a single object.');
            return;
        }

        const container = getContainer();

        notifications.forEach((notif, index) => {
            // Slight stagger for smoother visual layout when rendering multiple at once
            setTimeout(() => {
                const el = createNotificationElement(notif);
                container.appendChild(el);

                // Force a browser reflow so the starting position is registered before adding 'show'
                void el.offsetWidth;

                // Apply 'show' class to trigger appearance transition
                el.classList.add('show');
            }, index * 100);
        });
    }

    // Expose the public API
    return {
        show,
        close: closeNotification
    };
})();
