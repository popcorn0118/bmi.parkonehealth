document.addEventListener('DOMContentLoaded', init())

function init(){

    const homeAnime = document.querySelector('.home-anime')
    if(homeAnime){
        if (sessionStorage.getItem('be-inited') == 'true') {
        } else {
            // 第一次打開網頁
            sessionStorage.setItem('be-inited', 'true')
            homeAnime.classList.remove('d-none')
            setTimeout((e)=>{
                homeAnime.classList.add('d-none')
            }, 6000)
        }
    }

    let fade_position_arr = [];
    const fadeinArray = document.querySelectorAll('.fadein')

    function fadeinInit() {
        fade_position_arr = [];
        fadeinArray.forEach((ele) => {
            let pos = Math.round(offset(ele).top - (window.innerHeight * 1));
            fade_position_arr.push(pos); 
        })
        checkFadein(window.scrollY)
    }
    fadeinInit()

    function checkFadein(position){
        /* fade in */
        for (var i=0; i<fadeinArray.length ; i++) {
            if(position > fade_position_arr[i] && !fadeinArray[i].classList.contains('show')){
                let delay = fadeinArray[i].getAttribute('data-delay')
                if(delay){
                    let j = i;
                    setTimeout(() => {
                        fadeinAddShow(j)
                    }, delay)
                } else {
                    fadeinAddShow(i)
                }
            }else{
                // $(".fadein").eq(i).removeClass("show")
            }
        }
    }

    function fadeinAddShow(i){
        fadeinArray[i].classList.add("show")
    }

    function offset(el) {
        var rect = el.getBoundingClientRect(),
        scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
        scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        return { top: rect.top + scrollTop, left: rect.left + scrollLeft }
    }

    /**
     * safari vh
     */
    let windowsVH = window.innerHeight / 100;
    function safariHacks() {
        windowsVH = window.innerHeight / 100;
        document.querySelector('body').style.setProperty('--vh', windowsVH + 'px');
        
    }
    
    safariHacks();

    window.addEventListener('resize', function() {
        document.querySelector('body').style.setProperty('--vh', windowsVH + 'px');
        fadeinInit()
        addScrollEvent()
    });

    /**
     * masonry
     */
    const masonryGalleryImages = document.querySelectorAll('.masonry-gallery-images')
    masonryGalleryImages.forEach((masonryGallery) => {
        var msnry = new Masonry( masonryGallery, {
            columnWidth: '.masonry-sizer',
            itemSelector: '.masonry-image'
        });
        // console.log(msnry )

    })
    
    
    /**
     * lightbox img
     */
    const lightbox = GLightbox({
        touchNavigation: true,
        loop: true,
        autoplayVideos: true,
        zoomable: true
    });

    /**
     * top swiper
     */
    const topSwiper = new Swiper('.top-swiper', {
        speed: 600,
        spaceBetween: 0,
        loop: true,
    });
    if(topSwiper.$el){
        checkTopSlideDark(topSwiper)
        topSwiper.on('slideChange', function (e) {
            checkTopSlideDark(topSwiper)
            scrollToTop(0);
        });
    }

    function checkTopSlideDark(topSwiper){
        const header = document.querySelector('.site-header')
        let isDark = topSwiper.slides[topSwiper.activeIndex].getAttribute('data-is-dark')
        if(isDark){
            header.classList.add('text-white')
        }else {
            header.classList.remove('text-white')
        }
    }

    function scrollToTop(top){
        if(window.innerWidth >= 768){
            window.scrollTo({
                top: top,
                left: 0,
                behavior: 'smooth'
            });
        }else {
            document.querySelector('body').scrollTo({
                top: top,
                left: 0,
                behavior: 'smooth'
            });
        }
    }
    
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const swipe = urlParams.get('swipe')
    if(swipe > 0){
        topSwiper.slideTo(swipe)
    }
    const gotoDoctor = urlParams.get('doctor')
    if(gotoDoctor > 0){
        let targetDoctor = document.querySelector(`#doctor_select_${gotoDoctor}`)
        if(targetDoctor.classList.contains('tab-select')){
            let targetID = targetDoctor.getAttribute('data-tab')
            let target = document.querySelector(targetID)
            switchTab(target)
        }
        if(targetDoctor.classList.contains('doctor-select')){
            let doctorName = targetDoctor.innerHTML
            let doctorType = targetDoctor.getAttribute('data-type')
            switchDoctor(doctorName, doctorType)
        }
    }

    // swiper collapse
    const slideCollapseBtns = document.querySelectorAll('.swiper-slide .collapse-btn')
    slideCollapseBtns.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault()
            const collapse = e.target.closest('.swiper-slide').querySelector('.collapse-info')
            if(collapse){
                collapse.classList.toggle('show')
            }
        })
    })

    // swiper next
    const slideNextBtns = document.querySelectorAll('.swiper-slide .btn-next')
    if(topSwiper.$el && slideNextBtns){
        slideNextBtns.forEach((btn) => {
            btn.addEventListener('click', (e) => {
                topSwiper.slideNext();
            })
        })
    }

    /**
     * swiper services
     */
     const servicesSwiper = new Swiper('.services-swiper', {
        // Default parameters
        speed: 600,
        slidesPerView: 1,
        watchOverflow: false,
        centeredSlides: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 640px
            768: {
                centeredSlides: false,
                slidesPerView: 5,
                enabled: false,
            }
        }
    })

    if(servicesSwiper.$el){
        if(window.innerWidth < 768){
            servicesSwiper.slideTo(2)
        }
    }

    /**
     * swiper doctors home
     */
    checkDoctorHide()
    const dSwiper = new Swiper('.doctors-swiper', {
        // Default parameters
        speed: 1000,
        slidesPerView: 1,
        spaceBetween: 40,
        watchOverflow: false,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        // autoplay: {
        //     delay: 5000,
        // },
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= ()px
            560: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
            768: {
            slidesPerView: 2,
            spaceBetween: 80,
            }
        }
    })

    function checkDoctorHide(){
        const doctorsSwiper = document.querySelector('.doctors-swiper')
        if(doctorsSwiper){
            if (window.innerWidth > 1240){
                doctorsSwiper.querySelector('.home-doctor').classList.add('d-none')
            }else {
                doctorsSwiper.querySelector('.home-doctor').classList.remove('d-none')
            }
        }
    }

    /**
     * swiper program
     */
     const programSwiper = new Swiper('.program-swiper', {
        // Default parameters
        speed: 600,
        slidesPerView: 1,
        spaceBetween: 80,
        watchOverflow: false,
        centeredSlides: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 640px
            768: {
                centeredSlides: false,
                spaceBetween: 0,
                slidesPerView: 5,
                enabled: false,
            }
        }
    })
    if(programSwiper.$el){
        const index = document.querySelector('.program-swiper .program-item.current-item').getAttribute('data-index')
        programSwiper.slideTo(index)
    }

    programSwiper.on('slideChange', function () {
        if(window.innerWidth <= 768){
            const target = this.slides[this.activeIndex].querySelector('a')
            const url = target.getAttribute('href')
            const slug = target.getAttribute('data-slug')
            location.assign(url + '#page_' + slug)
        }
    });
    
    /**
     * 預期體重計算
     */
    const expectCard = document.querySelector('.expect-card')
    if(expectCard){
        const expectInputs = expectCard.querySelectorAll('.expect-input')
        const expectResults = expectCard.querySelectorAll('.expect-result')
        const expectBtn = expectCard.querySelector('.expect-btn')
        const expectHint = expectCard.querySelector('.expect-hint')
        const expectReduce = expectCard.querySelector('.expect-reduce')
        const expectResultWrap = expectCard.querySelector('.expect-result-wrap')
        expectBtn.addEventListener('click', (e) => {
            let height = expectInputs[0].value
            let weight = expectInputs[1].value
            if(!height || height < 20 || height > 500){
                expectHint.innerHTML = '請輸入正確的身高。'
                expectHint.classList.remove('d-none')
                expectInputs[0].focus()
            } else if (!weight || weight < 10 || weight > 1000) {
                expectHint.innerHTML = '請輸入正確的體重。'
                expectHint.classList.remove('d-none')
                expectInputs[1].focus()
            } else {
                expectHint.innerHTML = ''
                expectHint.classList.add('d-none')
                let result_0 = Math.round( 22 * (height/100) * (height/100) )
                let result_1 = Math.round( 24 * (height/100) * (height/100) )
                expectResults[0].value = result_0
                expectResults[1].value = result_1
                if(weight > result_1){
                    expectReduce.classList.remove('d-none')
                    expectResultWrap.classList.remove('d-none')
                    expectReduce.innerHTML = '減少約 '+ (weight - result_1) +'Kg'
                }else {
                    if(weight < result_0){
                        expectResultWrap.classList.add('d-none')
                    }
                    expectReduce.classList.remove('d-none')
                    expectReduce.innerHTML = '您的BMI已達標準範圍！';
                }
                expectCard.classList.add('show')

                let anchorTop = 0;
                if(window.innerWidth >= 768){
                    anchorTop = window.scrollY + 300;
                }else {
                    anchorTop = document.querySelector('body').scrollTop + 300
                }
                // console.log(anchorTop)
                scrollToTop(anchorTop)

                getPostByWeight(result_0, result_1)
            }
            
        })
    }

    /**
     * get post by weight
     */
    function getPostByWeight(ws = 0, we = 100){
        const base_url = window.location.origin == 'http://localhost' ? window.location.origin + '/parkone_bmmc': window.location.origin;
        const api_url = base_url + '/wp-json/get-post/v1/weight/' + ws + '-' + we;
        fetch(api_url)
        .then(function(response) {
            return response.json();
        })
        .then(function(myJson) {
            printPostInExpect(myJson);
        });
    }

    function printPostInExpect(postData){
        const expectPost = document.querySelector('.expect-post');
        if(expectPost){
            expectPost.querySelector('.entry-date').innerHTML = postData.date;
            expectPost.querySelector('.entry-title').innerHTML = postData.title;
            expectPost.querySelector('.entry-link').href = postData.link;
            expectPost.querySelector('.meta-time').innerHTML = postData.time;
            expectPost.querySelector('.meta-category').innerHTML = postData.category;
            expectPost.querySelector('.meta-weight-before').innerHTML = postData.weight_before;
            expectPost.querySelector('.meta-weight-after').innerHTML = postData.weight_after;
            expectPost.classList.add('show');
        }
    }

    /**
     * header
     */
     let prev = 0;
     const headerMenu = document.querySelector('.site-header');
     const headerTop = 0;
 
     function checkHeader(position){
         var bottom = document.innerHeight - window.innerHeight - 10;
         if (position <= headerTop ) {
             headerMenu.classList.remove('detached')
             headerMenu.classList.remove('show')
             headerMenu.classList.remove('detachedHide')
         }else{
             if (prev > position) {
                 prev = position;
                 headerMenu.classList.add('show')
             }else if(prev < position) {
                 prev = position;
                 headerMenu.classList.remove('show')
                 headerMenu.classList.add('detached')
                 headerMenu.classList.add('detachedHide')
             }
             if (position >= bottom) {
                 headerMenu.classList.add('show')
             }
         }
     }

     function addScrollEvent(){
        if(window.innerWidth >= 768){
            document.addEventListener('scroll', (e) => {
                lastKnownScrollPosition = window.scrollY;
                checkHeader(window.scrollY)
                checkFadein(window.scrollY)
            });
        }else {
            const body = document.querySelector('body')
            body.addEventListener('scroll', (e) => {
                lastKnownScrollPosition = body.scrollTop;
                checkHeader(body.scrollTop)
                checkFadein(body.scrollTop)
            });
        }
     }
    addScrollEvent()

    checkHeader(window.scrollY)

    /**
     * custom selects
     */
    const customSelects = document.querySelectorAll('.custom-selects')
    customSelects.forEach((selectGroup) => {
        selectGroup.addEventListener('click', (e) => {
            selectGroup.classList.toggle('active')
            if(e.target.classList.contains('custom-select')){
                selectGroup.querySelector('.active').classList.remove('active')
                e.target.classList.add('active')
            }
            if(e.target.classList.contains('tab-select')){
                let targetID = e.target.getAttribute('data-tab')
                let target = document.querySelector(targetID)
                switchTab(target)
            }
            if(e.target.classList.contains('doctor-select')){
                let doctorName = e.target.innerHTML
                let doctorType = e.target.getAttribute('data-type')
                switchDoctor(doctorName, doctorType)
            }
        })
    })

    function switchTab(target){
        let tabPrev = target.closest('.tab-list').querySelector('.tab.active')
        tabPrev.classList.remove('active')
        target.classList.add('active')
    }

    function switchDoctor(dName = '', dType = ''){
        document.querySelector('.doctor-name').innerHTML = dName
        document.querySelector('.doctor-type').innerHTML = dType
    }

    /**
     * env swiper
     */
     const envSwiper = new Swiper('.env-swiper', {
        // Default parameters
        speed: 600,
        slidesPerView: 1,
        spaceBetween: 40,
        watchOverflow: false,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 640px
            540: {
            slidesPerView: 2,
            spaceBetween: 40,
            }
        }
    })

    /**
     * collapse
     */
    const collapseBtns = document.querySelectorAll('.collapse-btn')
    collapseBtns.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault()
            let targetID = btn.getAttribute('href')
            if(targetID != '#' && targetID != ''){
                let target = document.querySelector(targetID)
                if(target){
                    btn.classList.toggle('active')
                    target.classList.toggle('active')
                }
            }
        })
    })
    
    /*更新動態(術後動態) 日期列表*/
    const copsDL = document.querySelectorAll('.case-post-operative-sterility.date-list .list .item a');
    copsDL.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            let targetIdx = btn.getAttribute('date-idx');
            const goCposWarp = document.getElementById(`cposWarp_${targetIdx}`);
            const goCpos = document.getElementById(`cpos_${targetIdx}`);
            const copsDI = document.querySelectorAll('.case-post-operative-sterility.detailed-info .list .item');

            //先全收合
            copsDI.forEach((cops) => {
                cops.children[0].children[0].classList.remove('active') //collapse-btn
                cops.children[1].classList.remove('active') //collapse-block
            })
            
            //點及到的展開
            goCposWarp.children[0].children[0].classList.add('active') //collapse-btn
            goCposWarp.children[1].classList.add('active') //collapse-block
            
        })
    })
    

    const searchWrap = document.querySelectorAll('.search-wrap')
    searchWrap.forEach((searchWrap) => {
        const selectInputs = searchWrap.querySelectorAll('input')
        const selected = [];
        selectInputs.forEach((input, index) => {
            selected[input.id] = input.value.split(',');
        })
        
        searchWrap.addEventListener('click', (e) => {
            if(!e.target.classList.contains('submit')){
                e.preventDefault();
            }
            if(e.target.classList.contains('search-select')){
                e.target.classList.toggle('active')
                let inputID = e.target.getAttribute('href')
                let selectInput = searchWrap.querySelector(inputID)
                arrayToggleValue(selected[inputID.slice(1)], e.target.getAttribute('data-value'))
                selectInput.value = selected[inputID.slice(1)].join()
            }
            if(e.target.classList.contains('search-clear')){
                searchWrap.querySelectorAll('.search-select.active').forEach((select) => {
                    select.classList.remove('active')
                })
                selectInputs.forEach((input, index) => {
                    input.value = '';
                    selected[input.id] = [];
                })
            }
        })
    })


    function arrayToggleValue(array, value) {
        var index = array.indexOf(value);
    
        if (index === -1) {
            array.push(value);
        } else {
            array.splice(index, 1);
        }

        array.sort((a, b)=> b - a)
    }

    /**
     * focus swiper
     */
     const focusSwiper = new Swiper('.focus-swiper', {
        // Default parameters
        speed: 600,
        slidesPerView: 1,
        spaceBetween: 40,
        watchOverflow: false,
        effect: 'fade',
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    })

    /**
     * Modal toggle
     */
    const modalToggler = document.querySelectorAll('.modal-toggler')
    modalToggler.forEach((toggler) => {
        const modalID = toggler.getAttribute('href')
        const modal = document.querySelector(modalID)
        const closeBtns = modal.querySelectorAll('.modal-close')
        toggler.addEventListener('click', (e) => {
            let scrollTop = window.scrollY
            document.querySelector('body').classList.toggle('modal-show')
            document.querySelector('body').scrollTop = scrollTop
            modal.classList.toggle('show')
            if(toggler.getAttribute('data-doctor')){
                let doctorID = toggler.getAttribute('data-doctor')
                document.querySelector(`#collapse_btn_${doctorID}`).click()
            }
        })
        if (modal.getAttribute('listener') !== 'true') {
            modal.addEventListener('click', function (e) {
                modal.setAttribute('listener', 'true');
                if(e.target.classList.contains('modal-close') || e.target.closest('.modal-close')){
                    document.querySelector('body').classList.remove('modal-show')
                    modal.classList.remove('show')
                }
                if(!e.target.closest('.modal-content')){
                    document.querySelector('body').classList.remove('modal-show')
                    modal.classList.remove('show')
                }
            });
       }
    })

    /**
     * Schedule
     */
    function Schedule(wrap, setting){
        this.wrap = document.querySelector(wrap)
        this.setting = setting;
        if(this.wrap){
            this.nextBtn = this.wrap.querySelector(setting.nextBtn)
            this.prevBtn = this.wrap.querySelector(setting.prevBtn)
            this.weekDayString = this.wrap.querySelector(setting.weekDayString) // 111/11/01 - 111/11/08
            this.singleDayStrings = this.wrap.querySelectorAll(setting.singleDayStrings) // 11/01... day string
            this.reserveBtns = this.wrap.querySelectorAll(setting.reserveBtns)
        }

        this.nowWeek = 0;
        this.maxWeek = setting.maxWeek || 4

        this.monday = getMondayOfCurrentWeek();
        this.sunday = new Date(this.monday);
        this.sunday.setDate(parseInt(this.sunday.getDate()) + 6);

        const _t = this

        if(_t.nextBtn && _t.prevBtn){
            _t.nextBtn.addEventListener('click', (e) => {
                changeWeekDate(1)
            })
            _t.prevBtn.addEventListener('click', (e) => {
                changeWeekDate(-1)
            })
            checkWeekBtnAvailable()
        }

        if(_t.reserveBtns){
            checkDateAvailable()
            if(setting.reserveDoubleClickOnMobile){
                enableDbClick()
            }
        }
              
        function getMondayOfCurrentWeek() {
            const today = new Date();
            const first = today.getDate() - today.getDay() + 1;
            const monday = new Date(today.setDate(first));
            return monday;
        }
        function changeWeekDate (changeWeek) {
            if(changeWeek == 1){
                _t.nowWeek ++
                _t.monday.setDate(parseInt(_t.monday.getDate()) + 7);
                _t.sunday.setDate(parseInt(_t.sunday.getDate()) + 7)
            } else {
                _t.nowWeek --
                _t.monday.setDate(parseInt(_t.monday.getDate()) - 7);
                _t.sunday.setDate(parseInt(_t.sunday.getDate()) - 7)
            }

            updateWeekDayString()
            updateReserveBtns()
            checkWeekBtnAvailable()
            checkDateAvailable()
        }
        function updateWeekDayString () {
            _t.weekDayString.innerHTML = formatDate(_t.monday, '/') + ' - ' + formatDate(_t.sunday, '/')
            _t.singleDayStrings.forEach((el, index) => {
                let date = new Date(_t.monday)
                date.setDate(parseInt(date.getDate()) + index)
                el.innerHTML = formatDay(date, '/')                
            })
        }
        function updateReserveBtns () {
            _t.reserveBtns.forEach((btn) => {
                let weekday = btn.getAttribute('data-weekday') // 1-7
                let dayHref = btn.getAttribute('href');
                let viewDate = dayHref.split('?')[1].split('&')[0].split('=')[1];
                let dayHrefText = dayHref.split(`viewDate=${viewDate}`)
                const thisDay = new Date(_t.monday);
                thisDay.setDate(thisDay.getDate() + (weekday - 1))
                let newViewDate = formatDate(thisDay)
                // console.log(newViewDate);
                btn.setAttribute('href', dayHrefText[0] + 'viewDate=' + newViewDate + dayHrefText[1]);
            })
        }
        function checkDateAvailable () {
            let now = Date.now()
            if( _t.nowWeek > 0 ){
                _t.reserveBtns.forEach((btn) => {
                    btn.classList.remove('disabled')
                })
            } else {
                _t.reserveBtns.forEach((btn) => {
                    let timestamp = btn.getAttribute('data-timestamp')
                    if(timestamp <= now && timestamp > 0){
                        btn.classList.add('disabled')
                    }else {
                        btn.classList.remove('disabled')
                    }
                })
            }
        }
        function checkWeekBtnAvailable (){
            if( _t.nowWeek <= 0 ){
                _t.prevBtn.classList.add('disabled')
            } else {
                _t.prevBtn.classList.remove('disabled')
            }
            if( _t.nowWeek >= _t.maxWeek ){
                _t.nextBtn.classList.add('disabled')
            } else {
                _t.nextBtn.classList.remove('disabled')
            }
        }
        function formatDate (date, parameters = '') {
                        let month = (date.getMonth() + 1).toString();
            if(month < 10){
                month = '0'+month;
            }
            let formattedDate = (date.getFullYear() - 1911) + parameters + (month) + parameters + ('0' + date.getDate()).slice(-2)
            
            return formattedDate
        }
        function formatDay (date, parameters = '') {
            let formattedDay = (date.getMonth() + 1) + parameters + ('0' + date.getDate()).slice(-2) 
            // console.log(formattedDay);
            return formattedDay
        }
        function enableDbClick () {
            _t.reserveBtns.forEach((btn) => {
                btn.addEventListener('click', function(e){
                    if(window.innerWidth < 768 && !btn.classList.contains('hover')){
                        e.preventDefault()
                        _t.reserveBtns.forEach((btn) => btn.classList.remove('hover') )
                        btn.classList.add('hover')
                    }
                })
            })
        }
    }

    const sidebarSchedule = new Schedule('#reserve_wrap', {
        'nextBtn': '#btn_next_week',
        'prevBtn': '#btn_prev_week',
        'weekDayString': '#week_string',
        'reserveBtns': '.btn-reserve-date'
    })

    const infoSchedule = new Schedule('#info_schedule', {
        'nextBtn': '.schedule-btn-next',
        'prevBtn': '.schedule-btn-prev',
        'weekDayString': '.schedule-weekday',
        'singleDayStrings': '.schedule-day',
        'reserveBtns': '.schedule-reserve-btn',
        'reserveDoubleClickOnMobile': true
    })

    /**
     * table rwd
     */
    function pkoTable(table){
        const _t = this;

        this.table = table
        this.btnNext = _t.table.querySelector('.pko-table-btn-next')
        this.btnPrev = _t.table.querySelector('.pko-table-btn-prev')

        const tbodyHasTh = _t.table.querySelectorAll('.pko-tbody .pko-tr:first-child .pko-th')
        this.thLength = tbodyHasTh.length
        this.maxColumn = _t.table.querySelectorAll('.pko-tbody .pko-tr:first-child > *').length - this.thLength;
        this.nowColumn = 1;

        if(this.thLength > 0){
            const theadThArray = _t.table.querySelectorAll(`.pko-thead .pko-th:nth-of-type(-n + ${this.thLength})`)
            theadThArray.forEach((th) => {
                th.classList.add('pko-th-head')
            })
        }


        toggleColumn(_t.nowColumn + _t.thLength)
        checkBtnsDisabled()

        if(_t.btnNext){
            _t.btnNext.addEventListener('click', (e) => {
                _t.nowColumn ++
                toggleColumn(_t.nowColumn + _t.thLength)
                checkBtnsDisabled()
            })
            _t.btnPrev.addEventListener('click', (e) => {
                _t.nowColumn --
                toggleColumn(_t.nowColumn + _t.thLength)
                checkBtnsDisabled()
            })
        }

        function toggleColumn(nth){
            const prevArray = _t.table.querySelectorAll(`.pko-tr > .active`)
            prevArray.forEach((pc) => pc.classList.remove('active'))
            const nowArray = _t.table.querySelectorAll(`.pko-tr > *:nth-of-type(${nth})`)
            nowArray.forEach((nc) => nc.classList.add('active'))
        }

        function checkBtnsDisabled(){
            if(_t.nowColumn <= 1){
                _t.btnPrev.disabled = true
            } else {
                _t.btnPrev.disabled = false
            }

            if(_t.nowColumn >= _t.maxColumn){
                _t.btnNext.disabled = true
            } else {
                _t.btnNext.disabled = false
            }
        }
        
    }

    function pkoTables(wrap){
        this.wraps = document.querySelectorAll(wrap)
        this.wraps.forEach((table) => {
            const _table = new pkoTable(table)
        })
    }

    const pTable = new pkoTables('.pko-table-wrap')

    /**
     * sticky event
     */
    // const observer = new IntersectionObserver( 
    //     ([e]) => e.target.classList.toggle("sticked", e.intersectionRatio < 1),
    //     { threshold: [1] }
    // );
    // const obSticky = document.querySelector("#page_group .sticky")
    // observer.observe(obSticky);

}