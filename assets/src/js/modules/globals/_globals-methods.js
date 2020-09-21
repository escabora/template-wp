const Methods = {

    init() {
        TEMPLATEWP.ajaxPosts = Methods.ajaxPosts;
        TEMPLATEWP.toggleOverlay = Methods.toggleOverlay;

        //set more Posts
        Methods.ajaxPostsPageInit();
    },

    toggleOverlay(cond) {
        if(cond) { 
            document.querySelector('.js--m-overlay').classList.add('is--active');
            TEMPLATEWP.body.classList.add('no-scroll');
        } else {
            document.querySelector('.js--m-overlay').classList.remove('is--active');
            TEMPLATEWP.body.classList.remove('no-scroll');
        }
    },

    ajaxPostsPageInit() {
        const buttonActiveMorePost = document.querySelector(".js--a-contentPost__btnMorePosts");
        if(buttonActiveMorePost && buttonActiveMorePost.getAttribute('data-page') == 'single') {
            const getParamDest = { category_name: 'sem-categoria' }
            let contentInsert = document.querySelector('.js--contentMorePosts');
            TEMPLATEWP.ajaxPosts(getParamDest, buttonActiveMorePost, contentInsert);
        }
    },

    _loaderAjaxMorePost(paramActive, btn) {
        const contentNotPost    = document.querySelector(".js--m-contentPost__notPost");
        const loader            = document.querySelector(".js--m-contentPost__loader-ajax");

        switch(paramActive) {
            case 'is--active-loader':
                (loader.classList.contains('is--hide')) ? loader.classList.remove('is--hide') : '';
                (btn.parentNode.classList.contains('is--hide')) ? '' : btn.parentNode.classList.add('is--hide');
                (contentNotPost.classList.contains('is--hide')) ? '' : contentNotPost.classList.add('is--hide');
                break;
            
            case 'is--active-btn':
                (loader.classList.contains('is--hide')) ? '' : loader.classList.add('is--hide');
                (btn.parentNode.classList.contains('is--hide')) ? btn.parentNode.classList.remove('is--hide') : '';
                (contentNotPost.classList.contains('is--hide')) ? '' : contentNotPost.classList.add('is--hide');
                break;
            
            case 'is--active-no-more-post':
                (loader.classList.contains('is--hide')) ? '' : loader.classList.add('is--hide');
                (btn.parentNode.classList.contains('is--hide')) ? '' : btn.parentNode.classList.add('is--hide');
                (contentNotPost.classList.contains('is--hide')) ? contentNotPost.classList.remove('is--hide') : '';
                break;     
        }

    },

    ajaxPosts(parameters, buttonAjax, contentInsert) {

        // ajuste btn more post quando a primeira busca do php retorna menos de 6 posts
        const post = document.querySelectorAll('.m-cardPost');
        
        if(post.length < 6) {
            document.querySelector('.js--a-contentPost__btnMorePosts').remove();
        }

        if(buttonAjax) {
            buttonAjax.addEventListener("click", (ev) => {
                ev.preventDefault();
                //active loader
                Methods._loaderAjaxMorePost('is--active-loader', buttonAjax);
                let page = buttonAjax.getAttribute('data-list-page');

                let data = `action=load_posts_by_ajax&page=${page}&security=${TEMPLATEWP.security}&`;
                
                let dataSerialize = "";
                for (let prop in parameters)
                    dataSerialize += prop + "=" + parameters[prop] + "&";
                
                // console.log(dataSerialize);
                fetch(TEMPLATEWP.adminAjax, {
                    method: "post",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8',
                    },
                    body: data + dataSerialize,
                })
                .then(res => res.text())
                .then(response => {
                    if(response.length) {
                        setTimeout((ev)=>{
                            
                            contentInsert.innerHTML += response;
                            buttonAjax.setAttribute('data-list-page', parseInt(page)+1 );
                            
                            // ajuste btn more post quando a primeira busca do ajax retorna menos de 6 posts
                            const post = document.querySelectorAll('.js--contentMorePosts .m-cardPost');

                            if(post.length < 6) {
                                Methods._loaderAjaxMorePost('is--active-no-more-post', buttonAjax)
                            } else {
                                //disable loader
                                Methods._loaderAjaxMorePost('is--active-btn', buttonAjax)
                            }


                        }, 1000);
                        
                    } else {
                        setTimeout((ev)=>{
                            
                            //enable not-post
                            Methods._loaderAjaxMorePost('is--active-no-more-post', buttonAjax)

                            // console.log("acabou");
                        },1000);
                    }
                    
                });
            });
        }
        
    },

}

export default {
    init: Methods.init,
}