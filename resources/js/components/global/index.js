import FadeTransition from "./transitions/FadeTransition.vue";
import SlideTopTransition from "./transitions/SlideTopTransition.vue";

import Fragment from "./Fragment.vue";
import Layout from "./Layout.vue";

import InputText from "primevue/inputtext";
import FloatLabel from "primevue/floatlabel";
import Dropdown from "primevue/dropdown";
import Button from "primevue/button";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ConfirmPopup from "primevue/confirmpopup";

export default [
    {
        name: "SlideTopTransition",
        component: SlideTopTransition,
    },
    {
        name: "FadeTransition",
        component: FadeTransition,
    },
    {
        name: "Fragment",
        component: Fragment,
    },
    {
        name: "Layout",
        component: Layout,
    },
    {
        name: "InputText",
        component: InputText,
    },
    {
        name: "FloatLabel",
        component: FloatLabel,
    },
    {
        name: "Dropdown",
        component: Dropdown,
    },
    {
        name: "Button",
        component: Button,
    },
    {
        name: "DataTable",
        component: DataTable,
    },
    {
        name: "Column",
        component: Column,
    },
    {
        name: "ConfirmPopup",
        component: ConfirmPopup,
    },
];
