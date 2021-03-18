const Methods = {

    init() {
        Methods.toogleMenuMobile();
    },

    toogleMenuMobile() {
        const btns = document.querySelectorAll('.js--a-buttonOpenMenuClick');
        const menu = document.querySelector('.m-header') 
        const openSearch = (ev) => {
            const _this = ev.currentTarget;
            ev.preventDefault();
            if(_this.getAttribute('data-change') == 'open') {
                TEMPLATEWP.toggleOverlay(true);
                menu.classList.add('--isActiveMenu');

            } else {
                menu.classList.remove('--isActiveMenu');
                TEMPLATEWP.toggleOverlay(false);
            }
        }
        if(btns.length > 0) [...btns].map((btn)=> btn.addEventListener('click', (ev) => openSearch(ev)));
    }

}

export default {
    init: Methods.init,
}