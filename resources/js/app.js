require('./bootstrap');

import { createApp } from 'vue'

const app = createApp({
    template: `<button @click="count++">{{ count }}</button>`,
    data() {
        return {
            count: 0
        }
    }
});

app.mount('#app')
