// Polyfills
import 'es6-promise/auto';

import 'unfetch/polyfill';

import Globals from './modules/globals/globals-index.js';
import MainHome from './modules/home/home-index.js';

window.TEMPLATEWP = window.TEMPLATEWP || {};

document.addEventListener('DOMContentLoaded', MainHome.init);
document.addEventListener('DOMContentLoaded', Globals.init);