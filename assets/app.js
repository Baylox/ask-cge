// Assets/app.js
import '@hotwired/turbo';
import { Application } from '@hotwired/stimulus';
import { registerControllers } from 'stimulus-vite-helpers';
import './styles/app.css';


// Enable Turbo (replaces traditional redirects)
Turbo.start()

// Stimulus
const app = Application.start();
registerControllers(app, import.meta.glob('./controllers/**/*_controller.js'));


// Additional JavaScript files 
import './controllers/theme.js';

import.meta.glob(['./images/**']);