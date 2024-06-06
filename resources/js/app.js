import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import axios from 'axios';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// Gestion des erreurs HTTP
// axios.interceptors.response.use(response => response, error => {
//     if (error.response) {
//         return Inertia.visit('/error', { 
//             data: { 
//                 code: error.response.status, 
//                 message: error.response.data.message 
//             } 
//         });
//     }

//     return Promise.reject(error);
// });

// Gestion de la protection XSRF
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('Jeton CSRF introuvable: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}