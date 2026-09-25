import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Esta linha é a mais importante para a interatividade
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import Alpine from 'alpinejs';
window.Alpine = Alpine;

Alpine.start();
