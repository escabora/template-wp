import GlobalHeader from './_globals-header.js';
import GlobalSearch from './_globals-search.js';
import GlobalMethods from './_globals-methods.js';

const init = () => {
    GlobalHeader.init();
    GlobalSearch.init();
    GlobalMethods.init();
}

export default {
    init: init,
}