import { usePage } from '@inertiajs/react';
import React from 'react';

type FlashProps = {
    flash?: {
        success?: string | null;
        error?: string | null;
    };
};

const AUTO_DISMISS_MS = 4000;

export default function GlobalToast() {
    const { flash } = usePage<FlashProps>().props;
    const successMessage = flash?.success ?? '';
    const errorMessage = flash?.error ?? '';
    const message = successMessage || errorMessage;
    const type = successMessage ? 'success' : 'error';
    const [visible, setVisible] = React.useState(false);

    React.useEffect(() => {
        if (!message) {
            setVisible(false);
            return;
        }

        setVisible(true);

        const timer = window.setTimeout(() => {
            setVisible(false);
        }, AUTO_DISMISS_MS);

        return () => window.clearTimeout(timer);
    }, [message]);

    if (!message || !visible) {
        return null;
    }

    return (
        <div className="pointer-events-none fixed right-4 top-4 z-[100] w-full max-w-sm">
            <div
                className={[
                    'rounded-xl border px-4 py-3 shadow-lg backdrop-blur transition-all duration-300',
                    type === 'success'
                        ? 'border-emerald-200 bg-emerald-50 text-emerald-800'
                        : 'border-red-200 bg-red-50 text-red-800',
                ].join(' ')}
                role="status"
                aria-live="polite"
            >
                <p className="text-sm font-medium">{message}</p>
            </div>
        </div>
    );
}