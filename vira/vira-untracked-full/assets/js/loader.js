/*WP JS LOADER by: Mdesign Licenced Under GNU----mdesign.fa@gmail.com-----ver 1.2.30*/
if(wpjsloadbymdz_active !== null && wpjsloadbymdz_active !== undefined && wpjsloadbymdz_active == "1"){
    
    var wpjsloadbymdz_adminbar = document.getElementById("wpadminbar");
    if(wpjsloadbymdz_adminbar === null || wpjsloadbymdz_adminbar === undefined){ 
    
    /*Prepare Loader-CSS Class*/
    if(wpjsloadbymdz_loaderclass !== null && wpjsloadbymdz_loaderclass !== undefined && wpjsloadbymdz_loaderclass != "" && wpjsloadbymdz_loaderclass != " "){
    
        var loader_css = wpjsloadbymdz_loaderclass;
    
    }else if(wpjsloadbymdz_loadereff !== null && wpjsloadbymdz_loadereff !== undefined && wpjsloadbymdz_loadereff != "" && wpjsloadbymdz_loadereff != " "){
    
        switch(wpjsloadbymdz_loadereff){
            case 'simple':
                var loader_css = "waiting-for-ajx1";
                break;
            case 'glassy':
                var loader_css = "waiting-for-ajx2";
                break;
            case 'fantasy':
                var loader_css = "waiting-for-ajx3";
                break;
            case 'xray':
                var loader_css = "waiting-for-ajx4";
                break;
            case 'dark':
                var loader_css = "waiting-for-ajx5";
                break;
            case 'sepia':
                var loader_css = "waiting-for-ajx6";
                break;
            case 'black':
                var loader_css = "waiting-for-ajx7";
                break;
            case 'blackglass':
                var loader_css = "waiting-for-ajx8";
                break;
        }
    
    }else var loader_css = "waiting-for-ajx1";
    /**/
    
    function wpjsloadermdz_timeConverter(unix, hours) {
        var date = new Date(unix);
    
        if(hours == '30'){
    
            hours = 30;
            data = date.setTime(date.getTime() + (hours * 60 * 1000));
    
        }else data = date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
        
        date = Math.floor(date.getTime() / 1000);
        return date;
    }
    function wpjsloadermdz_getpage_ajax(url, loader_css, donsethist){
    
        /*Define Cache-Class*/
        class wpjsloadermdz_localcache {
    
            check_get(url) {
    
                if(wpjsloadbymdz_cachetime != 'ses'){
    
                    var has = localStorage.getItem("" + url + "");
                    var is_valid = localStorage.getItem("" + url + "(exp-date)");
    
                }else var has = sessionStorage.getItem("" + url + "");
                
                if(wpjsloadbymdz_cachetime != 'ses'){
                    var now = Date.now();
                    now = Math.floor(now/1000);
    
                    if (is_valid !== null && (now > is_valid)) {
    
                        //Cache is Expired
                        localStorage.removeItem("" + url + "");
                        localStorage.removeItem("" + url + "(exp-date)");
                        return null;
    
                    }
                }
    
                return has;
            }
            set_storage(url, data, exp){
    
                if(wpjsloadbymdz_cachetime != 'ses'){
    
                    try {
    
                        localStorage.setItem("" + url + "", "" + data + "");
                        localStorage.setItem("" + url + "(exp-date)", "" + exp + "");
    
                    }
                    catch {
                        console.log("wpjsloader cache: could not set storage item!");
                    }
                    
    
                }else {
                    try {
    
                        sessionStorage.setItem("" + url + "", "" + data + "");
    
                    }
                    catch {
                        console.log("wpjsloader cache: could not set storage item!");
                    }
                    
                }
    
            }
            set(url, data) {
    
                var exp = Date.now();
    
                if(wpjsloadbymdz_cachetime !== null && wpjsloadbymdz_cachetime !== undefined){
    
                    if(wpjsloadbymdz_cachetime != "ses"){
    
                        wpjsloadbymdz_cachetime = parseInt(wpjsloadbymdz_cachetime);
                        exp = wpjsloadermdz_timeConverter(exp, wpjsloadbymdz_cachetime);
    
                    }else exp = "";
                    
                    
    
                }else exp = wpjsloadermdz_timeConverter(exp, 1);
    
                /*Check URLs*/
                var this_page_is_valid = true;
    
                if(wpjsloadbymdz_exc_cachepages !== null && wpjsloadbymdz_exc_cachepages !== undefined){
                    var exc_pages_arr = wpjsloadbymdz_exc_cachepages.split("|");
    
                    exc_pages_arr.forEach(function(page){
    
                        if(url == page){
                            this_page_is_valid = false;
                            return;
                        }
    
                    });
    
    
                    if(this_page_is_valid){
                        if(wpjsloadbymdz_doncache_q !== null && wpjsloadbymdz_doncache_q  !== undefined && wpjsloadbymdz_doncache_q == '1'){
    
                            if(url.includes("?") || url.includes("&")){
                                return;
                            }
                            this.set_storage(url, data, exp);
                            
    
                        }else this.set_storage(url, data, exp);
                        
                    }
                    
                }else {
    
                    if(wpjsloadbymdz_doncache_q !== null && wpjsloadbymdz_doncache_q  !== undefined && wpjsloadbymdz_doncache_q == '1'){
    
                        if(url.includes("?") || url.includes("&")){
                            return;
                        }
                        this.set_storage(url, data, exp);
    
                    }else this.set_storage(url, data, exp);
                    
                }
                /**/
            }
        }
        /**/
    
        let page_html = document.querySelector("html");
    
        if(wpjsloadbymdz_ajaxcache !== null && wpjsloadbymdz_ajaxcache !== undefined && wpjsloadbymdz_ajaxcache == '1'){
    
            var jq_ajax_cache = true;
    
        }else var jq_ajax_cache = false;
    
        var ajaxTime = new Date().getTime();
        //Get page content
        jQuery.ajax({
            url: url,
            method: "get",
            cache: jq_ajax_cache,
            error: function () {
                console.log("GET Error: from wpjs-loader plugin!");
                page_html.classList.remove(loader_css);
            },
            beforeSend: function () {

               if (wpjsloadbymdz_loding_line !== null && wpjsloadbymdz_loding_line !== undefined && wpjsloadbymdz_loding_line == '1'){
                 NProgress.start();
               }

               if (wpjsloadbymdz_loding_logo !== null && wpjsloadbymdz_loding_logo !== undefined && wpjsloadbymdz_loding_logo == '1'){
                 jQuery(".onliner_main_loading").addClass('stm-sms-load');
               }

                page_html.classList.add(loader_css);
    
                if(wpjsloadbymdz_cache !== null && wpjsloadbymdz_cache !== undefined && wpjsloadbymdz_cache == '1'){
    
                    if(wpjsloadbymdz_user_isin != '1' || wpjsloadbymdz_cache_uesrs == '1' || wpjsloadbymdz_cache_remover != '1'){
    
                        var urlcache = new wpjsloadermdz_localcache();
                        var has = urlcache.check_get(url);
     
                        if (has !== null && has !== undefined) {
                            wpjsloadermdz_doSomething(has, url, "cache", donsethist);
                            return false;
                        }
                    }
                }
    
            },
            success: function (resp) { 

                if (wpjsloadbymdz_loding_line !== null && wpjsloadbymdz_loding_line !== undefined && wpjsloadbymdz_loding_line == '1'){
                    NProgress.done();
                }
                if (wpjsloadbymdz_loding_logo !== null && wpjsloadbymdz_loding_logo !== undefined && wpjsloadbymdz_loding_logo == '1'){
                jQuery(".onliner_main_loading").removeClass('stm-sms-load');
                }
                
                if(wpjsloadbymdz_cache !== null && wpjsloadbymdz_cache !== undefined && wpjsloadbymdz_cache == '1'){
                    if(wpjsloadbymdz_user_isin != '1' || wpjsloadbymdz_cache_uesrs == '1' || wpjsloadbymdz_cache_remover){
    
                        var urlcache = new wpjsloadermdz_localcache();
                        urlcache.set(url, resp);
    
                    }        
                }
                var totalTime = new Date().getTime() - ajaxTime;
                wpjsloadermdz_doSomething(resp, url, totalTime, donsethist);
            }
        }).done(function(){
            if (wpjsloadbymdz_loding_line !== null && wpjsloadbymdz_loding_line !== undefined && wpjsloadbymdz_loding_line == '1'){
                NProgress.done();
            }
        });
    
    }
    function wpjsloadermdz_a_tags() {
    
        /*Prepare Options*/
        if(wpjsloadbymdz_exc_class !== null && wpjsloadbymdz_exc_class !== undefined){
    
            var exc_class_arr = wpjsloadbymdz_exc_class.split("|");
    
        }
    
        if(wpjsloadbymdz_exc_attrs !== null && wpjsloadbymdz_exc_attrs !== undefined){
    
            var exc_attrs_arr = wpjsloadbymdz_exc_attrs.split("|");
    
        }
    
        if(wpjsloadbymdz_exc_parclass !== null && wpjsloadbymdz_exc_parclass !== undefined){
    
            var exc_class_par_arr = wpjsloadbymdz_exc_parclass.split("|");
    
        }
    
        if(wpjsloadbymdz_exc_parattr !== null && wpjsloadbymdz_exc_parattr !== undefined){
    
            var exc_attrs_par_arr = wpjsloadbymdz_exc_parattr.split("|");
    
        }
        /**/
    
        var all_a_tags = document.getElementsByTagName("a");
    
        /*Loop on All A tags*/
        for (var mdz = 0; mdz < all_a_tags.length; mdz++) {
    
            //A tag Validation
            if(all_a_tags[mdz].hasAttribute("prk-url-to-fetch")){
                continue;
            }
    
            if(wpjsloadbymdz_onexts !== null && wpjsloadbymdz_onexts !== undefined && wpjsloadbymdz_onexts != '1'){
                if (all_a_tags[mdz].getAttribute("target") == "_blank") {
                    continue;
                }
            }
    
            exc_class_arr.forEach(function(css){
    
                if (all_a_tags[mdz].classList.contains(css)) {
                    all_a_tags[mdz].setAttribute("wpjsloadbymdz-igonore", "1");
                }
    
            });
    
            exc_attrs_arr.forEach(function(attr){
    
                if(attr.includes("=")){ 
    
                    var riz_arr = attr.split("=");
    
                    riz_arr[1] = riz_arr[1].replaceAll('"', '');
    
    
                    if (all_a_tags[mdz].getAttribute(riz_arr[0]) == riz_arr[1]) {
                        all_a_tags[mdz].setAttribute("wpjsloadbymdz-igonore", "1");
                    }
    
                }else {
    
                    if (all_a_tags[mdz].hasAttribute(attr)) {
                        all_a_tags[mdz].setAttribute("wpjsloadbymdz-igonore", "1");
                    }
    
                }
    
            });
    
            exc_class_par_arr.forEach(function(css){
    
                var tmp_par = all_a_tags[mdz].parentNode;
                if(tmp_par !== null && tmp_par !== undefined && tmp_par.classList.contains(css)){
                    all_a_tags[mdz].setAttribute("wpjsloadbymdz-igonore", "1");
                }
    
            });
    
            exc_attrs_par_arr.forEach(function(attr){
    
                if(attr.includes("=")){
    
                    var riz_arr = attr.split("=");
                    var tmp_par = all_a_tags[mdz].parentNode;
    
                    if (tmp_par !== null && tmp_par !== undefined && tmp_par.getAttribute(riz_arr[0]) == riz_arr[1]) {
                        all_a_tags[mdz].setAttribute("wpjsloadbymdz-igonore", "1");
                    }
    
                }else {
    
                    var tmp_par = all_a_tags[mdz].parentNode;
                    if (tmp_par !== null && tmp_par !== undefined && tmp_par.hasAttribute(attr)) {
                        all_a_tags[mdz].setAttribute("wpjsloadbymdz-igonore", "1");
                    }
    
                }
    
            });
    
            if (!all_a_tags[mdz].hasAttribute("href")) {
                continue;
            }
    
            var this_a_href = all_a_tags[mdz].getAttribute("href");
            if(!this_a_href.includes(wpjsloadbymdz_url)){
                continue;
            }
    
            if (all_a_tags[mdz].getAttribute("href") == "#") {
                continue;
            }else{
                var tmp_href = all_a_tags[mdz].getAttribute("href");
                var tmp_str = tmp_href.split("#");
    
                if(tmp_str[0].includes("#")){continue;}
            }
    
            if (all_a_tags[mdz].hasAttribute("wpjsloadbymdz-igonore")) {
                continue;
            }
            if (all_a_tags[mdz].hasAttribute("wpjsload-exc")) {
                continue;
            }
            if (all_a_tags[mdz].classList.contains("wpjsload-exc-class")) {
                continue;
            }
    
            var url_to_get = all_a_tags[mdz].getAttribute("href");
            all_a_tags[mdz].setAttribute("prk-url-to-fetch", url_to_get);
            /*all_a_tags[mdz].setAttribute("href", "#");*/
    
            all_a_tags[mdz].addEventListener("click", function (event) {
    
                event.preventDefault();
                var url_to_get = this.getAttribute("prk-url-to-fetch");
                wpjsloadermdz_getpage_ajax(url_to_get, loader_css, 1);
        
            });
        }
        /**/
    }
    function wpjsloadermdz_doSomething(data, url, mtd, donsethist) {
    
        console.clear();
    
        if (mtd == 'cache') {
            console.log("Page Loaded Form local-cache in 0 seconds by ajax-loader!");
        } else console.log("Page Fetched from server in " + mtd + " milli-seconds by ajax-loader!");
    
    
        document.open();
        document.write(data);
        document.close();
    
        /*history.replaceState('data to be passed', 'Title of the page', url);*/
        if(donsethist == '1'){
            history.pushState(null, '', url);
        }
    
        window.scrollTo(0, 0);
        wpjsloadermdz_a_tags();
    
    
    
    }
    jQuery(document).ready(function () { 
    
        wpjsloadermdz_a_tags();
    
        if(wpjsloadbymdz_doonscroll == '1'){
            window.addEventListener("scroll", wpjsloadermdz_a_tags);
        }
        
        if((wpjsloadbymdz_cache_remover == '1') || (wpjsloadbymdz_user_isin == '1' && wpjsloadbymdz_cache_uesrs == '0')){
            // localStorage.clear(); 
           
            for (let key in localStorage) {
                if (!key.startsWith('goftino')) { 
                localStorage.removeItem(key);
                }
            }
        }
    
    
    /*check for history api support*/
    if(window.history && history.pushState){ 
        window.addEventListener('load', function(){
    
            this.addEventListener('popstate', function(){
    
                var curr_url = location.href;
                wpjsloadermdz_getpage_ajax(curr_url, loader_css, 0);
    
    
            }, false);
        }, false);
    }
});
    }
    }