import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { initMorhenaDashboard } from './components/morhena/dashboard';

initMorhenaDashboard();
