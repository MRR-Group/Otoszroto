import './bootstrap';
import '../css/app.css';

import {createRoot} from 'react-dom/client';
import {createInertiaApp} from '@inertiajs/react';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import React, {ComponentType} from "react";

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
        const AppComponent = App as ComponentType<any>
        const content: any = <AppComponent {...(props as any)} />

        const root = createRoot(el);

        root.render(
            content
        );
    },
    progress: {
        color: '#4B5563',
    },
});
