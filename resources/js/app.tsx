import './bootstrap';
import '../css/app.css';

import {createRoot} from 'react-dom/client';
import {createInertiaApp} from '@inertiajs/react';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';

const appName = import.meta.env.VITE_APP_NAME || 'Otoszroto';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        return (
            await resolvePageComponent<any[]>(
                `./Pages/${name}.tsx`,
                import.meta.glob('./Pages/**/*.tsx') as any,
            )
        )[name.split('/').at(-1) as any];
    },
    setup({el, App, props}) {
        const root = createRoot(el);
        root.render(
            <App {...props}/>
        );
    },
    progress: {
        color: '#4B5563',
    },
});
