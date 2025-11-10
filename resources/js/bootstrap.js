import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Ajouter le token CSRF provenant de la balise meta (utile pour les formulaires Blade / SPA)
const token = document.head && document.head.querySelector('meta[name="csrf-token"]');
if (token) {
	window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// Envoyer les cookies (utile si vous utilisez Sanctum ou XSRF cookie)
window.axios.defaults.withCredentials = true;
