import './bootstrap';

import Alpine from 'alpinejs';

import 'flowbite';

import './custom/dark-mode.js';
import './custom/darkModeSystem.js';
import './custom/sidebar.js';
import './custom/custom.js';

window.Alpine = Alpine;

Alpine.start();

import.meta.glob([
    '../images/**',
]);
