import "./bootstrap";

import { createApp } from "vue";
import { createPinia } from "pinia";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";

import App from "./App.vue";

import router from "./router";

import PrimeVue from "primevue/config";
import Aura from '@primeuix/themes/aura';
import { definePreset } from '@primeuix/themes';
import "primeicons/primeicons.css";
import Ripple from "primevue/ripple";
import ToastService from "primevue/toastservice";
import ConfirmationService from "primevue/confirmationservice";

import Vue3TouchEvents from "vue3-touch-events";

import components from "./components/global";

const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

const app = createApp(App);

const DazzleTheme = definePreset(Aura, {
    semantic: {
        primary: {
            50: '{pink.50}',
            100: '{pink.100}',
            200: '{pink.200}',
            300: '{pink.300}',
            400: '{pink.400}',
            500: '{pink.500}',
            600: '{pink.600}',
            700: '{pink.700}',
            800: '{pink.800}',
            900: '{pink.900}',
            950: '{pink.950}'
        },
    }
});


app.use(PrimeVue, {
    ripple: true,
    theme: {
        preset: DazzleTheme,
        options: {
            darkModeSelector: '.dark',
            cssLayer: {
                name: 'primevue',
                order: 'base, primevue, components, utilities'
            }
        }
    },
    pt: {
        DataTable: {
            loadingIcon: {
                class: 'text-pink-500'
            },
            table: {
                class: '[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_th]:text-violet-700 [&_td]:text-violet-700'
            },
            footer: ({ props }) => ({
                class: props.value && props.value.length > 0 ? '' : 'hidden'
            })
        }
    }
});
app.directive("ripple", Ripple);
app.use(ToastService);
app.use(ConfirmationService);

components.forEach((component) => {
    app.component(component.name, component.component);
});

app.use(Vue3TouchEvents);
app.use(pinia);
app.use(router);
app.mount("#app");
