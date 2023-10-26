import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia'

import Alpine from 'alpinejs';
import TaskCard from './components/TaskCard.vue';
import TaskColumn from './components/TaskColumn.vue';
import KanbanBoard from './components/KanbanBoard.vue';
import GenericModal from './components/modals/GenericModal.vue';
import CustomSelectOption from "./components/global/CustomSelectOption.vue";
import CustomSuccessBtn from "./components/global/CustomSuccessBtn.vue";
import ErrorMessage from "./components/global/ErrorMessage.vue";
import InputField from "./components/global/InputField.vue";
import InputLabel from "./components/global/InputLabel.vue";

const pinia = createPinia()
const app = createApp({});
app.use(pinia);

app.component('TaskCard', TaskCard);
app.component('TaskColumn', TaskColumn);
app.component('KanbanBoard', KanbanBoard);
app.component('GenericModal', GenericModal);
app.component('CustomSelectOption', CustomSelectOption);
app.component('CustomSuccessBtn', CustomSuccessBtn);
app.component('ErrorMessage', ErrorMessage);
app.component('InputField', InputField);
app.component('InputLabel', InputLabel);

app.mount("#app");


window.Alpine = Alpine;

Alpine.start();
