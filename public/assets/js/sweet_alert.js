class AlertHandler {
    constructor(config = {}) {
        // Enterprise design tokens
        this.theme = {
            colors: {
                success: '#059669',
                error: '#DC2626',
                warning: '#D97706',
                info: '#2563EB',
                question: '#6366F1',
                neutral: '#64748B'
            },
            fonts: {
                title: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
                text: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif'
            }
        };

        this.defaultConfig = {
            customClass: {
                popup: 'enterprise-alert-popup',
                title: 'enterprise-alert-title',
                htmlContainer: 'enterprise-alert-text',
                confirmButton: 'enterprise-alert-btn enterprise-alert-btn-confirm',
                cancelButton: 'enterprise-alert-btn enterprise-alert-btn-cancel',
                icon: 'enterprise-alert-icon'
            },
            buttonsStyling: false,
            ...config
        };

        this.injectStyles();
    }

    /**
     * Inject enterprise CSS styles
     */
    injectStyles() {
        if (document.getElementById('enterprise-alert-styles')) return;

        const styles = `
            <style id="enterprise-alert-styles">
                /* Enterprise Alert Popup */
                .enterprise-alert-popup {
                    font-family: ${this.theme.fonts.text};
                    border-radius: 12px;
                    padding: 32px;
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 
                                0 10px 10px -5px rgba(0, 0, 0, 0.04);
                    border: 1px solid #E5E7EB;
                    background: #FFFFFF;
                    min-width: 400px;
                }

                /* Title */
                .enterprise-alert-title {
                    font-family: ${this.theme.fonts.title};
                    font-size: 20px;
                    font-weight: 600;
                    color: #111827;
                    margin-bottom: 12px;
                    line-height: 1.4;
                }

                /* Text Content */
                .enterprise-alert-text {
                    font-size: 14px;
                    color: #6B7280;
                    line-height: 1.6;
                    margin-bottom: 24px;
                }

                /* Icon Styling */
                .enterprise-alert-icon {
                    margin-bottom: 20px;
                }

                .swal2-icon.swal2-success {
                    border-color: ${this.theme.colors.success};
                    color: ${this.theme.colors.success};
                }

                .swal2-icon.swal2-success [class^='swal2-success-line'] {
                    background-color: ${this.theme.colors.success};
                }

                .swal2-icon.swal2-success .swal2-success-ring {
                    border-color: rgba(5, 150, 105, 0.3);
                }

                .swal2-icon.swal2-error {
                    border-color: ${this.theme.colors.error};
                    color: ${this.theme.colors.error};
                }

                .swal2-icon.swal2-error [class^='swal2-x-mark-line'] {
                    background-color: ${this.theme.colors.error};
                }

                .swal2-icon.swal2-warning {
                    border-color: ${this.theme.colors.warning};
                    color: ${this.theme.colors.warning};
                }

                .swal2-icon.swal2-info {
                    border-color: ${this.theme.colors.info};
                    color: ${this.theme.colors.info};
                }

                .swal2-icon.swal2-question {
                    border-color: ${this.theme.colors.question};
                    color: ${this.theme.colors.question};
                }

                /* Button Base Styles */
                .enterprise-alert-btn {
                    font-family: ${this.theme.fonts.text};
                    font-size: 14px;
                    font-weight: 500;
                    padding: 10px 24px;
                    border-radius: 8px;
                    border: none;
                    cursor: pointer;
                    transition: all 0.2s ease;
                    min-width: 100px;
                    text-transform: none;
                    letter-spacing: 0;
                }

                .enterprise-alert-btn:focus {
                    outline: none;
                    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
                }

                /* Confirm Button */
                .enterprise-alert-btn-confirm {
                    background: ${this.theme.colors.info};
                    color: #FFFFFF;
                    margin-right: 8px;
                }

                .enterprise-alert-btn-confirm:hover {
                    background: #1D4ED8;
                    transform: translateY(-1px);
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                }

                .enterprise-alert-btn-confirm:active {
                    transform: translateY(0);
                }

                /* Cancel Button */
                .enterprise-alert-btn-cancel {
                    background: #F3F4F6;
                    color: #374151;
                    border: 1px solid #E5E7EB;
                }

                .enterprise-alert-btn-cancel:hover {
                    background: #E5E7EB;
                    border-color: #D1D5DB;
                    transform: translateY(-1px);
                }

                /* Success Button Variant */
                .enterprise-alert-btn-success {
                    background: ${this.theme.colors.success};
                    color: #FFFFFF;
                }

                .enterprise-alert-btn-success:hover {
                    background: #047857;
                }

                /* Error Button Variant */
                .enterprise-alert-btn-error {
                    background: ${this.theme.colors.error};
                    color: #FFFFFF;
                }

                .enterprise-alert-btn-error:hover {
                    background: #B91C1C;
                }

                /* Warning Button Variant */
                .enterprise-alert-btn-warning {
                    background: ${this.theme.colors.warning};
                    color: #FFFFFF;
                }

                .enterprise-alert-btn-warning:hover {
                    background: #B45309;
                }

                /* Toast Notifications */
                .enterprise-toast {
                    border-radius: 8px;
                    padding: 16px 20px;
                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 
                                0 4px 6px -2px rgba(0, 0, 0, 0.05);
                    border-left: 4px solid;
                    background: #FFFFFF;
                }

                .enterprise-toast.swal2-success {
                    border-left-color: ${this.theme.colors.success};
                }

                .enterprise-toast.swal2-error {
                    border-left-color: ${this.theme.colors.error};
                }

                .enterprise-toast.swal2-warning {
                    border-left-color: ${this.theme.colors.warning};
                }

                .enterprise-toast.swal2-info {
                    border-left-color: ${this.theme.colors.info};
                }

                .enterprise-toast .swal2-title {
                    font-size: 15px;
                    font-weight: 600;
                    color: #111827;
                    margin: 0;
                }

                .enterprise-toast .swal2-html-container {
                    font-size: 13px;
                    color: #6B7280;
                    margin: 4px 0 0 0;
                }

                /* Loading Spinner */
                .swal2-loader {
                    border-color: ${this.theme.colors.info} transparent ${this.theme.colors.info} transparent;
                }

                /* Timer Progress Bar */
                .swal2-timer-progress-bar {
                    background: ${this.theme.colors.info};
                }

                /* Animations */
                @keyframes slideInRight {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }

                .swal2-show.enterprise-toast {
                    animation: slideInRight 0.3s ease-out;
                }
            </style>
        `;

        document.head.insertAdjacentHTML('beforeend', styles);
    }

    /**
     * Display success alert
     */
    success(message, options = {}) {
        return Swal.fire({
            icon: 'success',
            title: 'Success',
            text: message,
            confirmButtonText: 'OK',
            customClass: {
                ...this.defaultConfig.customClass,
                confirmButton: 'enterprise-alert-btn enterprise-alert-btn-success'
            },
            buttonsStyling: false,
            ...options
        });
    }

    /**
     * Display error alert
     */
    error(message, options = {}) {
        return Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            confirmButtonText: 'OK',
            customClass: {
                ...this.defaultConfig.customClass,
                confirmButton: 'enterprise-alert-btn enterprise-alert-btn-error'
            },
            buttonsStyling: false,
            ...options
        });
    }

    /**
     * Display warning alert
     */
    warning(message, options = {}) {
        return Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: message,
            confirmButtonText: 'OK',
            customClass: {
                ...this.defaultConfig.customClass,
                confirmButton: 'enterprise-alert-btn enterprise-alert-btn-warning'
            },
            buttonsStyling: false,
            ...options
        });
    }

    /**
     * Display info alert
     */
    info(message, options = {}) {
        return Swal.fire({
            icon: 'info',
            title: 'Information',
            text: message,
            confirmButtonText: 'OK',
            customClass: this.defaultConfig.customClass,
            buttonsStyling: false,
            ...options
        });
    }

    /**
     * Display confirmation dialog
     */
    confirm(message, options = {}) {
        return Swal.fire({
            icon: 'question',
            title: 'Confirm Action',
            text: message,
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            customClass: this.defaultConfig.customClass,
            buttonsStyling: false,
            focusCancel: true,
            ...options
        });
    }

    /**
     * Display loading alert
     */
    loading(message = 'Processing...') {
        return Swal.fire({
            title: message,
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            customClass: this.defaultConfig.customClass,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    /**
     * Toast notifications (non-intrusive)
     */
    toast(type, message, options = {}) {
        const toastConfig = {
            icon: type,
            title: this.getToastTitle(type),
            text: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            customClass: {
                popup: 'enterprise-toast',
                title: 'swal2-title',
                htmlContainer: 'swal2-html-container'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        };

        return Swal.fire({ ...toastConfig, ...options });
    }

    /**
     * Success toast
     */
    successToast(message, options = {}) {
        return this.toast('success', message, options);
    }

    /**
     * Error toast
     */
    errorToast(message, options = {}) {
        return this.toast('error', message, options);
    }

    /**
     * Warning toast
     */
    warningToast(message, options = {}) {
        return this.toast('warning', message, options);
    }

    /**
     * Info toast
     */
    infoToast(message, options = {}) {
        return this.toast('info', message, options);
    }

    /**
     * Get toast title based on type
     */
    getToastTitle(type) {
        const titles = {
            success: 'Success',
            error: 'Error',
            warning: 'Warning',
            info: 'Information'
        };
        return titles[type] || 'Notification';
    }

    /**
     * Close any open alert
     */
    close() {
        Swal.close();
    }

    /**
     * Handle AJAX response automatically
     */
    handleResponse(response, useToast = false) {
        const isSuccess = response.status === 'success' || response.status === 1 || response.status === '1';
        const message = response.message || (isSuccess ? 'Operation completed successfully' : 'An error occurred');

        if (useToast) {
            return isSuccess ? this.successToast(message) : this.errorToast(message);
        } else {
            return isSuccess ? this.success(message) : this.error(message);
        }
    }

    /**
     * Handle AJAX request with loading state
     */
    async handleRequest(promise, loadingMessage = 'Processing...', useToast = false) {
        this.loading(loadingMessage);
        
        try {
            const response = await promise;
            this.close();
            this.handleResponse(response, useToast);
            return response;
        } catch (error) {
            this.close();
            const errorMessage = error.message || 'Network error. Please try again.';
            
            if (useToast) {
                this.errorToast(errorMessage);
            } else {
                this.error(errorMessage);
            }
            throw error;
        }
    }
}
// Initialize global instance
const Alert = new AlertHandler();