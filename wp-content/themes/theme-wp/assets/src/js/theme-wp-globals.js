// Polyfills
import 'es6-promise/auto';
import 'unfetch/polyfill';

// Vendors
import './modules/vendors/scrolldir';

import Globals from './modules/globals/index.js';

document.addEventListener('DOMContentLoaded', Globals.init);