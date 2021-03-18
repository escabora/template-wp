const Methods = {

    init() {
        Methods.toggleSearchForm();
    },

    toggleSearchForm() {
        const btns = document.querySelectorAll('.js--a-searchFormMenuClick');
        const searchformContent = document.querySelector('.js--m-searchFormMenu') 
        const openSearch = (ev) => {
            const _this = ev.currentTarget;
            ev.preventDefault();
            return _this.getAttribute('data-change') == 'open' ? searchformContent.classList.add('--isActiveSearchForm') : searchformContent.classList.remove('--isActiveSearchForm')
        }
        if(btns.length > 0) [...btns].map((btn)=> btn.addEventListener('click', (ev) => openSearch(ev)));
    }

}

export default {
    init: Methods.init,
}