import $$ from 'dom7';
import Framework7 from 'framework7/framework7.esm.bundle.js';

// Import F7 Styles
import 'framework7/css/framework7.bundle.css';

// Import Icons and App Custom Styles
import '../css/icons.css';
import '../css/app.styl';

// Import Routes
import routes from './routes.js';

// Import main app component
import App from '../app.f7.html';

import t7Helpers from './t7-helpers.js';



var app = new Framework7({
  root: '#app', // App root element
  component: App, // App main component
  
  name: 'amigos-sierra', // App name
  theme: 'auto', // Automatic theme detection
  data: {
    token: 'Basic a2V5XzZ2VjJ6Mkh5SjdOS3hNcWU1cmJlcVE6',
    server: 'https://donar.amigosdelasierra.org/administrador/public/amigos-sierra',
  },
  
  view: {
    pushState: true
  },

  // App routes
  routes: routes,
  // Register service worker
  serviceWorker: {
    path: '/service-worker.js',
  },
});