<style>
    @keyframes toast-slide-in {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes toast-slide-out {
        from { transform: translateX(0); opacity: 1; max-height: 200px; }
        to { transform: translateX(100%); opacity: 0; max-height: 0; margin: 0; padding: 0; }
    }
    .toast-in { animation: toast-slide-in 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .toast-out { animation: toast-slide-out 0.3s cubic-bezier(0.7, 0, 0.84, 0) forwards; }
    #toast-container > div { pointer-events: auto; }
</style>

<script>
    function showToast(type, title, message) {
        console.log('Showing toast:', type, title, message);
        const container = document.getElementById('toast-container');
        if (!container) {
            console.error('Toast container not found');
            return;
        }

        const toast = document.createElement('div');
        const config = {
            success: { bg: '#ecfdf5', border: '#10b981', icon: '#10b981', title: '#065f46', msg: '#065f46',
                       path: 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z' },
            info:    { bg: '#eff6ff', border: '#3b82f6', icon: '#3b82f6', title: '#1e40af', msg: '#1e40af',
                       path: 'M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z' },
            error:   { bg: '#fef2f2', border: '#ef4444', icon: '#ef4444', title: '#991b1b', msg: '#991b1b',
                       path: 'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z' },
            warning: { bg: '#fffbeb', border: '#f59e0b', icon: '#f59e0b', title: '#92400e', msg: '#92400e',
                       path: 'M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z' }
        };

        const c = config[type] || config.info;
        toast.className = 'toast-in';
        toast.style.cssText = `
            background-color: ${c.bg};
            border-left: 4px solid ${c.border};
            padding: 16px;
            border-radius: 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: flex-start;
            gap: 12px;
            transition: all 0.3s;
            pointer-events: auto;
            min-width: 300px;
        `;

        toast.innerHTML = `
            <svg style="width: 24px; height: 24px; flex-shrink: 0; color: ${c.icon}" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="${c.path}" clip-rule="evenodd"></path>
            </svg>
            <div style="flex: 1; min-width: 0;">
                <p style="margin: 0; font-size: 14px; font-weight: 700; color: ${c.title}">${title}</p>
                <p style="margin: 4px 0 0 0; font-size: 12px; color: ${c.msg}">${message}</p>
            </div>
            <button onclick="this.parentElement.classList.add('toast-out'); setTimeout(() => this.parentElement.remove(), 300)" style="flex-shrink: 0; color: #9ca3af; background: none; border: none; cursor: pointer; padding: 4px;">
                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        `;

        container.appendChild(toast);
        setTimeout(() => {
            if (toast.parentElement) {
                toast.classList.add('toast-out');
                setTimeout(() => toast.remove(), 300);
            }
        }, 5000);
    }

    // Direct execution
    @if(session('success')) showToast('success', 'Success', @json(session('success'))); @endif
    @if(session('info')) showToast('info', 'Info', @json(session('info'))); @endif
    @if(session('status')) showToast('info', 'Status', @json(session('status'))); @endif
    @if(session('warning')) showToast('warning', 'Warning', @json(session('warning'))); @endif
    @if(session('error')) showToast('error', 'Error', @json(session('error'))); @endif
    @if(session('message')) showToast('info', 'Notification', @json(session('message'))); @endif
    @if($errors->any())
        (function() {
            const errors = @json($errors->all());
            showToast('error', 'Validation Error', errors.length === 1 ? errors[0] : 'Please check the form for errors.');
        })();
    @endif
</script>