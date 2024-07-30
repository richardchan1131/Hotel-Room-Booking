<section data-anim-wrap="" class="masthead -type-5 animated bravo-tour-service">
    <div data-anim-child="fade" class="masthead__bg is-in-view">
        <img src="{{ asset('themes/gotrip/images/bg.svg') }}" alt="bg">
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xl-9">
                <h1 data-anim-child="slide-up delay-4" class="text-60 lg:text-40 md:text-30 is-in-view">{{ $title ?? '' }}</h1>

                <p data-anim-child="slide-up delay-5" class="mt-20 is-in-view subtitle">{{ $sub_title ?? '' }}</p>

                <div class="mt-35 form-search-service-tour">
                    @include('Tour::frontend.layouts.search.form-search',['style' => 'normal'])
                </div>
                {{--<div data-anim-child="slide-up delay-6" class="mainSearch bg-white pr-20 py-20 lg:px-20 lg:pt-5 lg:pb-20 rounded-4 shadow-1 mt-35 is-in-view">
                    <div class="button-grid items-center">

                        <div class="searchMenu-loc px-30 lg:py-20 lg:px-0 js-form-dd js-liverSearch">

                            <div data-x-dd-click="searchMenu-loc">
                                <h4 class="text-15 fw-500 ls-2 lh-16">Location</h4>

                                <div class="text-15 text-light-1 ls-2 lh-16">
                                    <input autocomplete="off" type="search" placeholder="Where are you going?" class="js-search js-dd-focus">
                                </div>
                            </div>


                            <div class="searchMenu-loc__field shadow-2 js-popup-window" data-x-dd="searchMenu-loc" data-x-dd-toggle="-is-active">
                                <div class="bg-white px-30 py-30 sm:px-0 sm:py-15 rounded-4">
                                    <div class="y-gap-5 js-results">

                                        <div>
                                            <button class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option">
                                                <div class="d-flex">
                                                    <div class="icon-location-2 text-light-1 text-20 pt-4"></div>
                                                    <div class="ml-10">
                                                        <div class="text-15 lh-12 fw-500 js-search-option-target">London</div>
                                                        <div class="text-14 lh-12 text-light-1 mt-5">Greater London, United Kingdom</div>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>

                                        <div>
                                            <button class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option">
                                                <div class="d-flex">
                                                    <div class="icon-location-2 text-light-1 text-20 pt-4"></div>
                                                    <div class="ml-10">
                                                        <div class="text-15 lh-12 fw-500 js-search-option-target">New York</div>
                                                        <div class="text-14 lh-12 text-light-1 mt-5">New York State, United States</div>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>

                                        <div>
                                            <button class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option">
                                                <div class="d-flex">
                                                    <div class="icon-location-2 text-light-1 text-20 pt-4"></div>
                                                    <div class="ml-10">
                                                        <div class="text-15 lh-12 fw-500 js-search-option-target">Paris</div>
                                                        <div class="text-14 lh-12 text-light-1 mt-5">France</div>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>

                                        <div>
                                            <button class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option">
                                                <div class="d-flex">
                                                    <div class="icon-location-2 text-light-1 text-20 pt-4"></div>
                                                    <div class="ml-10">
                                                        <div class="text-15 lh-12 fw-500 js-search-option-target">Madrid</div>
                                                        <div class="text-14 lh-12 text-light-1 mt-5">Spain</div>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>

                                        <div>
                                            <button class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option">
                                                <div class="d-flex">
                                                    <div class="icon-location-2 text-light-1 text-20 pt-4"></div>
                                                    <div class="ml-10">
                                                        <div class="text-15 lh-12 fw-500 js-search-option-target">Santorini</div>
                                                        <div class="text-14 lh-12 text-light-1 mt-5">Greece</div>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="searchMenu-date px-30 lg:py-20 lg:px-0 js-form-dd js-calendar">

                            <div data-x-dd-click="searchMenu-date">
                                <h4 class="text-15 fw-500 ls-2 lh-16">Check in - Check out</h4>

                                <div class="text-15 text-light-1 ls-2 lh-16">
                                    <span class="js-first-date">Wed 2 Mar</span>
                                    -
                                    <span class="js-last-date">Fri 11 Apr</span>
                                </div>
                            </div>


                            <div class="searchMenu-date__field shadow-2" data-x-dd="searchMenu-date" data-x-dd-toggle="-is-active">
                                <div class="bg-white px-30 py-30 rounded-4">
                                    <div class="overflow-hidden js-calendar-slider swiper-initialized swiper-horizontal swiper-pointer-events swiper-autoheight">
                                        <div class="swiper-wrapper" id="swiper-wrapper-dfb7cc993379136e" aria-live="polite" style="height: 416px;">


                                            <div class="swiper-slide swiper-slide-active" role="group" aria-label="1 / 12" style="width: 420px;">
                                                <div class="text-28 fw-500 text-center mb-10">January 2022</div>

                                                <div class="table-calendar js-calendar-single">
                                                    <div class="table-calendar__header">
                                                        <div>Sun</div>
                                                        <div>Mon</div>
                                                        <div>Tue</div>
                                                        <div>Wed</div>
                                                        <div>Thu</div>
                                                        <div>Fri</div>
                                                        <div>Sat</div>
                                                    </div>

                                                    <div class="table-calendar__grid overflow-hidden">

                                                        <div data-index="1" data-week="Sun" data-month="Dec" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">26</span>


                                                        </div>


                                                        <div data-index="2" data-week="Mon" data-month="Dec" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="3" data-week="Tue" data-month="Dec" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="4" data-week="Wed" data-month="Dec" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="5" data-week="Thu" data-month="Dec" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                        <div data-index="6" data-week="Fri" data-month="Dec" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">31</span>


                                                        </div>


                                                        <div data-index="7" data-week="Sat" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">1</span>


                                                        </div>


                                                        <div data-index="8" data-week="Sun" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">2</span>


                                                        </div>


                                                        <div data-index="9" data-week="Mon" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">3</span>


                                                        </div>


                                                        <div data-index="10" data-week="Tue" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">4</span>


                                                        </div>


                                                        <div data-index="11" data-week="Wed" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">5</span>


                                                        </div>


                                                        <div data-index="12" data-week="Thu" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">6</span>


                                                        </div>


                                                        <div data-index="13" data-week="Fri" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">7</span>


                                                        </div>


                                                        <div data-index="14" data-week="Sat" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">8</span>


                                                        </div>


                                                        <div data-index="15" data-week="Sun" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">9</span>


                                                        </div>


                                                        <div data-index="16" data-week="Mon" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">10</span>


                                                        </div>


                                                        <div data-index="17" data-week="Tue" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">11</span>


                                                        </div>


                                                        <div data-index="18" data-week="Wed" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">12</span>


                                                        </div>


                                                        <div data-index="19" data-week="Thu" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">13</span>


                                                        </div>


                                                        <div data-index="20" data-week="Fri" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">14</span>


                                                        </div>


                                                        <div data-index="21" data-week="Sat" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">15</span>


                                                        </div>


                                                        <div data-index="22" data-week="Sun" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">16</span>


                                                        </div>


                                                        <div data-index="23" data-week="Mon" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">17</span>


                                                        </div>


                                                        <div data-index="24" data-week="Tue" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">18</span>


                                                        </div>


                                                        <div data-index="25" data-week="Wed" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">19</span>


                                                        </div>


                                                        <div data-index="26" data-week="Thu" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">20</span>


                                                        </div>


                                                        <div data-index="27" data-week="Fri" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">21</span>


                                                        </div>


                                                        <div data-index="28" data-week="Sat" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">22</span>


                                                        </div>


                                                        <div data-index="29" data-week="Sun" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">23</span>


                                                        </div>


                                                        <div data-index="30" data-week="Mon" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">24</span>


                                                        </div>


                                                        <div data-index="31" data-week="Tue" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">25</span>


                                                        </div>


                                                        <div data-index="32" data-week="Wed" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">26</span>


                                                        </div>


                                                        <div data-index="33" data-week="Thu" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="34" data-week="Fri" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="35" data-week="Sat" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="36" data-week="Sun" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                        <div data-index="37" data-week="Mon" data-month="Jan" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">31</span>


                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="swiper-slide swiper-slide-next" role="group" aria-label="2 / 12" style="width: 420px;">
                                                <div class="text-28 fw-500 text-center mb-10">February 2022</div>

                                                <div class="table-calendar js-calendar-single">
                                                    <div class="table-calendar__header">
                                                        <div>Sun</div>
                                                        <div>Mon</div>
                                                        <div>Tue</div>
                                                        <div>Wed</div>
                                                        <div>Thu</div>
                                                        <div>Fri</div>
                                                        <div>Sat</div>
                                                    </div>

                                                    <div class="table-calendar__grid overflow-hidden">

                                                        <div data-index="38" data-week="Sun" data-month="Jan" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                        <div data-index="39" data-week="Mon" data-month="Jan" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">31</span>


                                                        </div>


                                                        <div data-index="40" data-week="Tue" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">1</span>


                                                        </div>


                                                        <div data-index="41" data-week="Wed" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">2</span>


                                                        </div>


                                                        <div data-index="42" data-week="Thu" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">3</span>


                                                        </div>


                                                        <div data-index="43" data-week="Fri" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">4</span>


                                                        </div>


                                                        <div data-index="44" data-week="Sat" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">5</span>


                                                        </div>


                                                        <div data-index="45" data-week="Sun" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">6</span>


                                                        </div>


                                                        <div data-index="46" data-week="Mon" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">7</span>


                                                        </div>


                                                        <div data-index="47" data-week="Tue" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">8</span>


                                                        </div>


                                                        <div data-index="48" data-week="Wed" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">9</span>


                                                        </div>


                                                        <div data-index="49" data-week="Thu" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">10</span>


                                                        </div>


                                                        <div data-index="50" data-week="Fri" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">11</span>


                                                        </div>


                                                        <div data-index="51" data-week="Sat" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">12</span>


                                                        </div>


                                                        <div data-index="52" data-week="Sun" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">13</span>


                                                        </div>


                                                        <div data-index="53" data-week="Mon" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">14</span>


                                                        </div>


                                                        <div data-index="54" data-week="Tue" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">15</span>


                                                        </div>


                                                        <div data-index="55" data-week="Wed" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">16</span>


                                                        </div>


                                                        <div data-index="56" data-week="Thu" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">17</span>


                                                        </div>


                                                        <div data-index="57" data-week="Fri" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">18</span>


                                                        </div>


                                                        <div data-index="58" data-week="Sat" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">19</span>


                                                        </div>


                                                        <div data-index="59" data-week="Sun" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">20</span>


                                                        </div>


                                                        <div data-index="60" data-week="Mon" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">21</span>


                                                        </div>


                                                        <div data-index="61" data-week="Tue" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">22</span>


                                                        </div>


                                                        <div data-index="62" data-week="Wed" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">23</span>


                                                        </div>


                                                        <div data-index="63" data-week="Thu" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">24</span>


                                                        </div>


                                                        <div data-index="64" data-week="Fri" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">25</span>


                                                        </div>


                                                        <div data-index="65" data-week="Sat" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">26</span>


                                                        </div>


                                                        <div data-index="66" data-week="Sun" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="67" data-week="Mon" data-month="Feb" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="swiper-slide" role="group" aria-label="3 / 12" style="width: 420px;">
                                                <div class="text-28 fw-500 text-center mb-10">March 2022</div>

                                                <div class="table-calendar js-calendar-single">
                                                    <div class="table-calendar__header">
                                                        <div>Sun</div>
                                                        <div>Mon</div>
                                                        <div>Tue</div>
                                                        <div>Wed</div>
                                                        <div>Thu</div>
                                                        <div>Fri</div>
                                                        <div>Sat</div>
                                                    </div>

                                                    <div class="table-calendar__grid overflow-hidden">

                                                        <div data-index="68" data-week="Sun" data-month="Feb" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="69" data-week="Mon" data-month="Feb" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="70" data-week="Tue" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">1</span>


                                                        </div>


                                                        <div data-index="71" data-week="Wed" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">2</span>


                                                        </div>


                                                        <div data-index="72" data-week="Thu" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">3</span>


                                                        </div>


                                                        <div data-index="73" data-week="Fri" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">4</span>


                                                        </div>


                                                        <div data-index="74" data-week="Sat" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">5</span>


                                                        </div>


                                                        <div data-index="75" data-week="Sun" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">6</span>


                                                        </div>


                                                        <div data-index="76" data-week="Mon" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">7</span>


                                                        </div>


                                                        <div data-index="77" data-week="Tue" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">8</span>


                                                        </div>


                                                        <div data-index="78" data-week="Wed" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">9</span>


                                                        </div>


                                                        <div data-index="79" data-week="Thu" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">10</span>


                                                        </div>


                                                        <div data-index="80" data-week="Fri" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">11</span>


                                                        </div>


                                                        <div data-index="81" data-week="Sat" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">12</span>


                                                        </div>


                                                        <div data-index="82" data-week="Sun" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">13</span>


                                                        </div>


                                                        <div data-index="83" data-week="Mon" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">14</span>


                                                        </div>


                                                        <div data-index="84" data-week="Tue" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">15</span>


                                                        </div>


                                                        <div data-index="85" data-week="Wed" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">16</span>


                                                        </div>


                                                        <div data-index="86" data-week="Thu" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">17</span>


                                                        </div>


                                                        <div data-index="87" data-week="Fri" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">18</span>


                                                        </div>


                                                        <div data-index="88" data-week="Sat" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">19</span>


                                                        </div>


                                                        <div data-index="89" data-week="Sun" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">20</span>


                                                        </div>


                                                        <div data-index="90" data-week="Mon" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">21</span>


                                                        </div>


                                                        <div data-index="91" data-week="Tue" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">22</span>


                                                        </div>


                                                        <div data-index="92" data-week="Wed" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">23</span>


                                                        </div>


                                                        <div data-index="93" data-week="Thu" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">24</span>


                                                        </div>


                                                        <div data-index="94" data-week="Fri" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">25</span>


                                                        </div>


                                                        <div data-index="95" data-week="Sat" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">26</span>


                                                        </div>


                                                        <div data-index="96" data-week="Sun" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="97" data-week="Mon" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="98" data-week="Tue" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="99" data-week="Wed" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                        <div data-index="100" data-week="Thu" data-month="Mar" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">31</span>


                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="swiper-slide" role="group" aria-label="4 / 12" style="width: 420px;">
                                                <div class="text-28 fw-500 text-center mb-10">April 2022</div>

                                                <div class="table-calendar js-calendar-single">
                                                    <div class="table-calendar__header">
                                                        <div>Sun</div>
                                                        <div>Mon</div>
                                                        <div>Tue</div>
                                                        <div>Wed</div>
                                                        <div>Thu</div>
                                                        <div>Fri</div>
                                                        <div>Sat</div>
                                                    </div>

                                                    <div class="table-calendar__grid overflow-hidden">

                                                        <div data-index="101" data-week="Sun" data-month="Mar" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="102" data-week="Mon" data-month="Mar" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="103" data-week="Tue" data-month="Mar" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="104" data-week="Wed" data-month="Mar" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                        <div data-index="105" data-week="Thu" data-month="Mar" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">31</span>


                                                        </div>


                                                        <div data-index="106" data-week="Fri" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">1</span>


                                                        </div>


                                                        <div data-index="107" data-week="Sat" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">2</span>


                                                        </div>


                                                        <div data-index="108" data-week="Sun" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">3</span>


                                                        </div>


                                                        <div data-index="109" data-week="Mon" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">4</span>


                                                        </div>


                                                        <div data-index="110" data-week="Tue" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">5</span>


                                                        </div>


                                                        <div data-index="111" data-week="Wed" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">6</span>


                                                        </div>


                                                        <div data-index="112" data-week="Thu" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">7</span>


                                                        </div>


                                                        <div data-index="113" data-week="Fri" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">8</span>


                                                        </div>


                                                        <div data-index="114" data-week="Sat" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">9</span>


                                                        </div>


                                                        <div data-index="115" data-week="Sun" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">10</span>


                                                        </div>


                                                        <div data-index="116" data-week="Mon" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">11</span>


                                                        </div>


                                                        <div data-index="117" data-week="Tue" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">12</span>


                                                        </div>


                                                        <div data-index="118" data-week="Wed" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">13</span>


                                                        </div>


                                                        <div data-index="119" data-week="Thu" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">14</span>


                                                        </div>


                                                        <div data-index="120" data-week="Fri" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">15</span>


                                                        </div>


                                                        <div data-index="121" data-week="Sat" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">16</span>


                                                        </div>


                                                        <div data-index="122" data-week="Sun" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">17</span>


                                                        </div>


                                                        <div data-index="123" data-week="Mon" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">18</span>


                                                        </div>


                                                        <div data-index="124" data-week="Tue" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">19</span>


                                                        </div>


                                                        <div data-index="125" data-week="Wed" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">20</span>


                                                        </div>


                                                        <div data-index="126" data-week="Thu" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">21</span>


                                                        </div>


                                                        <div data-index="127" data-week="Fri" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">22</span>


                                                        </div>


                                                        <div data-index="128" data-week="Sat" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">23</span>


                                                        </div>


                                                        <div data-index="129" data-week="Sun" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">24</span>


                                                        </div>


                                                        <div data-index="130" data-week="Mon" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">25</span>


                                                        </div>


                                                        <div data-index="131" data-week="Tue" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">26</span>


                                                        </div>


                                                        <div data-index="132" data-week="Wed" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="133" data-week="Thu" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="134" data-week="Fri" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="135" data-week="Sat" data-month="Apr" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="swiper-slide" role="group" aria-label="5 / 12" style="width: 420px;">
                                                <div class="text-28 fw-500 text-center mb-10">May 2022</div>

                                                <div class="table-calendar js-calendar-single">
                                                    <div class="table-calendar__header">
                                                        <div>Sun</div>
                                                        <div>Mon</div>
                                                        <div>Tue</div>
                                                        <div>Wed</div>
                                                        <div>Thu</div>
                                                        <div>Fri</div>
                                                        <div>Sat</div>
                                                    </div>

                                                    <div class="table-calendar__grid overflow-hidden">

                                                        <div data-index="136" data-week="Sun" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">1</span>


                                                        </div>


                                                        <div data-index="137" data-week="Mon" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">2</span>


                                                        </div>


                                                        <div data-index="138" data-week="Tue" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">3</span>


                                                        </div>


                                                        <div data-index="139" data-week="Wed" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">4</span>


                                                        </div>


                                                        <div data-index="140" data-week="Thu" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">5</span>


                                                        </div>


                                                        <div data-index="141" data-week="Fri" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">6</span>


                                                        </div>


                                                        <div data-index="142" data-week="Sat" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">7</span>


                                                        </div>


                                                        <div data-index="143" data-week="Sun" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">8</span>


                                                        </div>


                                                        <div data-index="144" data-week="Mon" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">9</span>


                                                        </div>


                                                        <div data-index="145" data-week="Tue" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">10</span>


                                                        </div>


                                                        <div data-index="146" data-week="Wed" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">11</span>


                                                        </div>


                                                        <div data-index="147" data-week="Thu" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">12</span>


                                                        </div>


                                                        <div data-index="148" data-week="Fri" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">13</span>


                                                        </div>


                                                        <div data-index="149" data-week="Sat" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">14</span>


                                                        </div>


                                                        <div data-index="150" data-week="Sun" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">15</span>


                                                        </div>


                                                        <div data-index="151" data-week="Mon" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">16</span>


                                                        </div>


                                                        <div data-index="152" data-week="Tue" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">17</span>


                                                        </div>


                                                        <div data-index="153" data-week="Wed" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">18</span>


                                                        </div>


                                                        <div data-index="154" data-week="Thu" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">19</span>


                                                        </div>


                                                        <div data-index="155" data-week="Fri" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">20</span>


                                                        </div>


                                                        <div data-index="156" data-week="Sat" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">21</span>


                                                        </div>


                                                        <div data-index="157" data-week="Sun" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">22</span>


                                                        </div>


                                                        <div data-index="158" data-week="Mon" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">23</span>


                                                        </div>


                                                        <div data-index="159" data-week="Tue" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">24</span>


                                                        </div>


                                                        <div data-index="160" data-week="Wed" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">25</span>


                                                        </div>


                                                        <div data-index="161" data-week="Thu" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">26</span>


                                                        </div>


                                                        <div data-index="162" data-week="Fri" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="163" data-week="Sat" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="164" data-week="Sun" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="165" data-week="Mon" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                        <div data-index="166" data-week="Tue" data-month="May" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">31</span>


                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="swiper-slide" role="group" aria-label="6 / 12" style="width: 420px;">
                                                <div class="text-28 fw-500 text-center mb-10">June 2022</div>

                                                <div class="table-calendar js-calendar-single">
                                                    <div class="table-calendar__header">
                                                        <div>Sun</div>
                                                        <div>Mon</div>
                                                        <div>Tue</div>
                                                        <div>Wed</div>
                                                        <div>Thu</div>
                                                        <div>Fri</div>
                                                        <div>Sat</div>
                                                    </div>

                                                    <div class="table-calendar__grid overflow-hidden">

                                                        <div data-index="167" data-week="Sun" data-month="May" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="168" data-week="Mon" data-month="May" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                        <div data-index="169" data-week="Tue" data-month="May" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">31</span>


                                                        </div>


                                                        <div data-index="170" data-week="Wed" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">1</span>


                                                        </div>


                                                        <div data-index="171" data-week="Thu" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">2</span>


                                                        </div>


                                                        <div data-index="172" data-week="Fri" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">3</span>


                                                        </div>


                                                        <div data-index="173" data-week="Sat" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">4</span>


                                                        </div>


                                                        <div data-index="174" data-week="Sun" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">5</span>


                                                        </div>


                                                        <div data-index="175" data-week="Mon" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">6</span>


                                                        </div>


                                                        <div data-index="176" data-week="Tue" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">7</span>


                                                        </div>


                                                        <div data-index="177" data-week="Wed" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">8</span>


                                                        </div>


                                                        <div data-index="178" data-week="Thu" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">9</span>


                                                        </div>


                                                        <div data-index="179" data-week="Fri" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">10</span>


                                                        </div>


                                                        <div data-index="180" data-week="Sat" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">11</span>


                                                        </div>


                                                        <div data-index="181" data-week="Sun" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">12</span>


                                                        </div>


                                                        <div data-index="182" data-week="Mon" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">13</span>


                                                        </div>


                                                        <div data-index="183" data-week="Tue" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">14</span>


                                                        </div>


                                                        <div data-index="184" data-week="Wed" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">15</span>


                                                        </div>


                                                        <div data-index="185" data-week="Thu" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">16</span>


                                                        </div>


                                                        <div data-index="186" data-week="Fri" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">17</span>


                                                        </div>


                                                        <div data-index="187" data-week="Sat" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">18</span>


                                                        </div>


                                                        <div data-index="188" data-week="Sun" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">19</span>


                                                        </div>


                                                        <div data-index="189" data-week="Mon" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">20</span>


                                                        </div>


                                                        <div data-index="190" data-week="Tue" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">21</span>


                                                        </div>


                                                        <div data-index="191" data-week="Wed" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">22</span>


                                                        </div>


                                                        <div data-index="192" data-week="Thu" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">23</span>


                                                        </div>


                                                        <div data-index="193" data-week="Fri" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">24</span>


                                                        </div>


                                                        <div data-index="194" data-week="Sat" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">25</span>


                                                        </div>


                                                        <div data-index="195" data-week="Sun" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">26</span>


                                                        </div>


                                                        <div data-index="196" data-week="Mon" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="197" data-week="Tue" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="198" data-week="Wed" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="199" data-week="Thu" data-month="Jun" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="swiper-slide" role="group" aria-label="7 / 12" style="width: 420px;">
                                                <div class="text-28 fw-500 text-center mb-10">July 2022</div>

                                                <div class="table-calendar js-calendar-single">
                                                    <div class="table-calendar__header">
                                                        <div>Sun</div>
                                                        <div>Mon</div>
                                                        <div>Tue</div>
                                                        <div>Wed</div>
                                                        <div>Thu</div>
                                                        <div>Fri</div>
                                                        <div>Sat</div>
                                                    </div>

                                                    <div class="table-calendar__grid overflow-hidden">

                                                        <div data-index="200" data-week="Sun" data-month="Jun" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">26</span>


                                                        </div>


                                                        <div data-index="201" data-week="Mon" data-month="Jun" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="202" data-week="Tue" data-month="Jun" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="203" data-week="Wed" data-month="Jun" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="204" data-week="Thu" data-month="Jun" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                        <div data-index="205" data-week="Fri" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">1</span>


                                                        </div>


                                                        <div data-index="206" data-week="Sat" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">2</span>


                                                        </div>


                                                        <div data-index="207" data-week="Sun" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">3</span>


                                                        </div>


                                                        <div data-index="208" data-week="Mon" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">4</span>


                                                        </div>


                                                        <div data-index="209" data-week="Tue" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">5</span>


                                                        </div>


                                                        <div data-index="210" data-week="Wed" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">6</span>


                                                        </div>


                                                        <div data-index="211" data-week="Thu" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">7</span>


                                                        </div>


                                                        <div data-index="212" data-week="Fri" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">8</span>


                                                        </div>


                                                        <div data-index="213" data-week="Sat" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">9</span>


                                                        </div>


                                                        <div data-index="214" data-week="Sun" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">10</span>


                                                        </div>


                                                        <div data-index="215" data-week="Mon" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">11</span>


                                                        </div>


                                                        <div data-index="216" data-week="Tue" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">12</span>


                                                        </div>


                                                        <div data-index="217" data-week="Wed" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">13</span>


                                                        </div>


                                                        <div data-index="218" data-week="Thu" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">14</span>


                                                        </div>


                                                        <div data-index="219" data-week="Fri" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">15</span>


                                                        </div>


                                                        <div data-index="220" data-week="Sat" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">16</span>


                                                        </div>


                                                        <div data-index="221" data-week="Sun" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">17</span>


                                                        </div>


                                                        <div data-index="222" data-week="Mon" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">18</span>


                                                        </div>


                                                        <div data-index="223" data-week="Tue" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">19</span>


                                                        </div>


                                                        <div data-index="224" data-week="Wed" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">20</span>


                                                        </div>


                                                        <div data-index="225" data-week="Thu" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">21</span>


                                                        </div>


                                                        <div data-index="226" data-week="Fri" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">22</span>


                                                        </div>


                                                        <div data-index="227" data-week="Sat" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">23</span>


                                                        </div>


                                                        <div data-index="228" data-week="Sun" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">24</span>


                                                        </div>


                                                        <div data-index="229" data-week="Mon" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">25</span>


                                                        </div>


                                                        <div data-index="230" data-week="Tue" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">26</span>


                                                        </div>


                                                        <div data-index="231" data-week="Wed" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="232" data-week="Thu" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="233" data-week="Fri" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="234" data-week="Sat" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                        <div data-index="235" data-week="Sun" data-month="Jul" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">31</span>


                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="swiper-slide" role="group" aria-label="8 / 12" style="width: 420px;">
                                                <div class="text-28 fw-500 text-center mb-10">August 2022</div>

                                                <div class="table-calendar js-calendar-single">
                                                    <div class="table-calendar__header">
                                                        <div>Sun</div>
                                                        <div>Mon</div>
                                                        <div>Tue</div>
                                                        <div>Wed</div>
                                                        <div>Thu</div>
                                                        <div>Fri</div>
                                                        <div>Sat</div>
                                                    </div>

                                                    <div class="table-calendar__grid overflow-hidden">

                                                        <div data-index="236" data-week="Sun" data-month="Jul" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">31</span>


                                                        </div>


                                                        <div data-index="237" data-week="Mon" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">1</span>


                                                        </div>


                                                        <div data-index="238" data-week="Tue" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">2</span>


                                                        </div>


                                                        <div data-index="239" data-week="Wed" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">3</span>


                                                        </div>


                                                        <div data-index="240" data-week="Thu" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">4</span>


                                                        </div>


                                                        <div data-index="241" data-week="Fri" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">5</span>


                                                        </div>


                                                        <div data-index="242" data-week="Sat" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">6</span>


                                                        </div>


                                                        <div data-index="243" data-week="Sun" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">7</span>


                                                        </div>


                                                        <div data-index="244" data-week="Mon" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">8</span>


                                                        </div>


                                                        <div data-index="245" data-week="Tue" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">9</span>


                                                        </div>


                                                        <div data-index="246" data-week="Wed" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">10</span>


                                                        </div>


                                                        <div data-index="247" data-week="Thu" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">11</span>


                                                        </div>


                                                        <div data-index="248" data-week="Fri" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">12</span>


                                                        </div>


                                                        <div data-index="249" data-week="Sat" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">13</span>


                                                        </div>


                                                        <div data-index="250" data-week="Sun" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">14</span>


                                                        </div>


                                                        <div data-index="251" data-week="Mon" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">15</span>


                                                        </div>


                                                        <div data-index="252" data-week="Tue" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">16</span>


                                                        </div>


                                                        <div data-index="253" data-week="Wed" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">17</span>


                                                        </div>


                                                        <div data-index="254" data-week="Thu" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">18</span>


                                                        </div>


                                                        <div data-index="255" data-week="Fri" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">19</span>


                                                        </div>


                                                        <div data-index="256" data-week="Sat" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">20</span>


                                                        </div>


                                                        <div data-index="257" data-week="Sun" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">21</span>


                                                        </div>


                                                        <div data-index="258" data-week="Mon" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">22</span>


                                                        </div>


                                                        <div data-index="259" data-week="Tue" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">23</span>


                                                        </div>


                                                        <div data-index="260" data-week="Wed" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">24</span>


                                                        </div>


                                                        <div data-index="261" data-week="Thu" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">25</span>


                                                        </div>


                                                        <div data-index="262" data-week="Fri" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">26</span>


                                                        </div>


                                                        <div data-index="263" data-week="Sat" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="264" data-week="Sun" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="265" data-week="Mon" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="266" data-week="Tue" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                        <div data-index="267" data-week="Wed" data-month="Aug" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">31</span>


                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="swiper-slide" role="group" aria-label="9 / 12" style="width: 420px;">
                                                <div class="text-28 fw-500 text-center mb-10">September 2022</div>

                                                <div class="table-calendar js-calendar-single">
                                                    <div class="table-calendar__header">
                                                        <div>Sun</div>
                                                        <div>Mon</div>
                                                        <div>Tue</div>
                                                        <div>Wed</div>
                                                        <div>Thu</div>
                                                        <div>Fri</div>
                                                        <div>Sat</div>
                                                    </div>

                                                    <div class="table-calendar__grid overflow-hidden">

                                                        <div data-index="268" data-week="Sun" data-month="Aug" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="269" data-week="Mon" data-month="Aug" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="270" data-week="Tue" data-month="Aug" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                        <div data-index="271" data-week="Wed" data-month="Aug" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">31</span>


                                                        </div>


                                                        <div data-index="272" data-week="Thu" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">1</span>


                                                        </div>


                                                        <div data-index="273" data-week="Fri" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">2</span>


                                                        </div>


                                                        <div data-index="274" data-week="Sat" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">3</span>


                                                        </div>


                                                        <div data-index="275" data-week="Sun" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">4</span>


                                                        </div>


                                                        <div data-index="276" data-week="Mon" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">5</span>


                                                        </div>


                                                        <div data-index="277" data-week="Tue" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">6</span>


                                                        </div>


                                                        <div data-index="278" data-week="Wed" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">7</span>


                                                        </div>


                                                        <div data-index="279" data-week="Thu" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">8</span>


                                                        </div>


                                                        <div data-index="280" data-week="Fri" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">9</span>


                                                        </div>


                                                        <div data-index="281" data-week="Sat" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">10</span>


                                                        </div>


                                                        <div data-index="282" data-week="Sun" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">11</span>


                                                        </div>


                                                        <div data-index="283" data-week="Mon" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">12</span>


                                                        </div>


                                                        <div data-index="284" data-week="Tue" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">13</span>


                                                        </div>


                                                        <div data-index="285" data-week="Wed" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">14</span>


                                                        </div>


                                                        <div data-index="286" data-week="Thu" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">15</span>


                                                        </div>


                                                        <div data-index="287" data-week="Fri" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">16</span>


                                                        </div>


                                                        <div data-index="288" data-week="Sat" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">17</span>


                                                        </div>


                                                        <div data-index="289" data-week="Sun" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">18</span>


                                                        </div>


                                                        <div data-index="290" data-week="Mon" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">19</span>


                                                        </div>


                                                        <div data-index="291" data-week="Tue" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">20</span>


                                                        </div>


                                                        <div data-index="292" data-week="Wed" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">21</span>


                                                        </div>


                                                        <div data-index="293" data-week="Thu" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">22</span>


                                                        </div>


                                                        <div data-index="294" data-week="Fri" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">23</span>


                                                        </div>


                                                        <div data-index="295" data-week="Sat" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">24</span>


                                                        </div>


                                                        <div data-index="296" data-week="Sun" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">25</span>


                                                        </div>


                                                        <div data-index="297" data-week="Mon" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">26</span>


                                                        </div>


                                                        <div data-index="298" data-week="Tue" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="299" data-week="Wed" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="300" data-week="Thu" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="301" data-week="Fri" data-month="Sep" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="swiper-slide" role="group" aria-label="10 / 12" style="width: 420px;">
                                                <div class="text-28 fw-500 text-center mb-10">October 2022</div>

                                                <div class="table-calendar js-calendar-single">
                                                    <div class="table-calendar__header">
                                                        <div>Sun</div>
                                                        <div>Mon</div>
                                                        <div>Tue</div>
                                                        <div>Wed</div>
                                                        <div>Thu</div>
                                                        <div>Fri</div>
                                                        <div>Sat</div>
                                                    </div>

                                                    <div class="table-calendar__grid overflow-hidden">

                                                        <div data-index="302" data-week="Sun" data-month="Sep" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">25</span>


                                                        </div>


                                                        <div data-index="303" data-week="Mon" data-month="Sep" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">26</span>


                                                        </div>


                                                        <div data-index="304" data-week="Tue" data-month="Sep" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="305" data-week="Wed" data-month="Sep" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="306" data-week="Thu" data-month="Sep" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="307" data-week="Fri" data-month="Sep" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                        <div data-index="308" data-week="Sat" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">1</span>


                                                        </div>


                                                        <div data-index="309" data-week="Sun" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">2</span>


                                                        </div>


                                                        <div data-index="310" data-week="Mon" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">3</span>


                                                        </div>


                                                        <div data-index="311" data-week="Tue" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">4</span>


                                                        </div>


                                                        <div data-index="312" data-week="Wed" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">5</span>


                                                        </div>


                                                        <div data-index="313" data-week="Thu" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">6</span>


                                                        </div>


                                                        <div data-index="314" data-week="Fri" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">7</span>


                                                        </div>


                                                        <div data-index="315" data-week="Sat" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">8</span>


                                                        </div>


                                                        <div data-index="316" data-week="Sun" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">2</span>


                                                        </div>


                                                        <div data-index="317" data-week="Mon" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">3</span>


                                                        </div>


                                                        <div data-index="318" data-week="Tue" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">4</span>


                                                        </div>


                                                        <div data-index="319" data-week="Wed" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">5</span>


                                                        </div>


                                                        <div data-index="320" data-week="Thu" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">6</span>


                                                        </div>


                                                        <div data-index="321" data-week="Fri" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">7</span>


                                                        </div>


                                                        <div data-index="322" data-week="Sat" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">8</span>


                                                        </div>


                                                        <div data-index="323" data-week="Sun" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">9</span>


                                                        </div>


                                                        <div data-index="324" data-week="Mon" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">10</span>


                                                        </div>


                                                        <div data-index="325" data-week="Tue" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">11</span>


                                                        </div>


                                                        <div data-index="326" data-week="Wed" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">12</span>


                                                        </div>


                                                        <div data-index="327" data-week="Thu" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">13</span>


                                                        </div>


                                                        <div data-index="328" data-week="Fri" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">14</span>


                                                        </div>


                                                        <div data-index="329" data-week="Sat" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">15</span>


                                                        </div>


                                                        <div data-index="330" data-week="Sun" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">16</span>


                                                        </div>


                                                        <div data-index="331" data-week="Mon" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">17</span>


                                                        </div>


                                                        <div data-index="332" data-week="Tue" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">18</span>


                                                        </div>


                                                        <div data-index="333" data-week="Wed" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">19</span>


                                                        </div>


                                                        <div data-index="334" data-week="Thu" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">20</span>


                                                        </div>


                                                        <div data-index="335" data-week="Fri" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">21</span>


                                                        </div>


                                                        <div data-index="336" data-week="Sat" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">22</span>


                                                        </div>


                                                        <div data-index="337" data-week="Sun" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">23</span>


                                                        </div>


                                                        <div data-index="338" data-week="Mon" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">24</span>


                                                        </div>


                                                        <div data-index="339" data-week="Tue" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">25</span>


                                                        </div>


                                                        <div data-index="340" data-week="Wed" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">26</span>


                                                        </div>


                                                        <div data-index="341" data-week="Thu" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="342" data-week="Fri" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="343" data-week="Sat" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="344" data-week="Sun" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                        <div data-index="345" data-week="Mon" data-month="Oct" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">31</span>


                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="swiper-slide" role="group" aria-label="11 / 12" style="width: 420px;">
                                                <div class="text-28 fw-500 text-center mb-10">November 2022</div>

                                                <div class="table-calendar js-calendar-single">
                                                    <div class="table-calendar__header">
                                                        <div>Sun</div>
                                                        <div>Mon</div>
                                                        <div>Tue</div>
                                                        <div>Wed</div>
                                                        <div>Thu</div>
                                                        <div>Fri</div>
                                                        <div>Sat</div>
                                                    </div>

                                                    <div class="table-calendar__grid overflow-hidden">

                                                        <div data-index="346" data-week="Sun" data-month="Oct" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                        <div data-index="347" data-week="Mon" data-month="Oct" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">31</span>


                                                        </div>


                                                        <div data-index="348" data-week="Tue" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">1</span>


                                                        </div>


                                                        <div data-index="349" data-week="Wed" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">2</span>


                                                        </div>


                                                        <div data-index="350" data-week="Thu" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">3</span>


                                                        </div>


                                                        <div data-index="351" data-week="Fri" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">4</span>


                                                        </div>


                                                        <div data-index="352" data-week="Sat" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">5</span>


                                                        </div>


                                                        <div data-index="353" data-week="Sun" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">6</span>


                                                        </div>


                                                        <div data-index="354" data-week="Mon" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">7</span>


                                                        </div>


                                                        <div data-index="355" data-week="Tue" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">8</span>


                                                        </div>


                                                        <div data-index="356" data-week="Wed" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">2</span>


                                                        </div>


                                                        <div data-index="357" data-week="Thu" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">3</span>


                                                        </div>


                                                        <div data-index="358" data-week="Fri" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">4</span>


                                                        </div>


                                                        <div data-index="359" data-week="Sat" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">5</span>


                                                        </div>


                                                        <div data-index="360" data-week="Sun" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">6</span>


                                                        </div>


                                                        <div data-index="361" data-week="Mon" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">7</span>


                                                        </div>


                                                        <div data-index="362" data-week="Tue" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">8</span>


                                                        </div>


                                                        <div data-index="363" data-week="Wed" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">9</span>


                                                        </div>


                                                        <div data-index="364" data-week="Thu" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">10</span>


                                                        </div>


                                                        <div data-index="365" data-week="Fri" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">11</span>


                                                        </div>


                                                        <div data-index="366" data-week="Sat" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">12</span>


                                                        </div>


                                                        <div data-index="367" data-week="Sun" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">13</span>


                                                        </div>


                                                        <div data-index="368" data-week="Mon" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">14</span>


                                                        </div>


                                                        <div data-index="369" data-week="Tue" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">15</span>


                                                        </div>


                                                        <div data-index="370" data-week="Wed" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">16</span>


                                                        </div>


                                                        <div data-index="371" data-week="Thu" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">17</span>


                                                        </div>


                                                        <div data-index="372" data-week="Fri" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">18</span>


                                                        </div>


                                                        <div data-index="373" data-week="Sat" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">19</span>


                                                        </div>


                                                        <div data-index="374" data-week="Sun" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">20</span>


                                                        </div>


                                                        <div data-index="375" data-week="Mon" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">21</span>


                                                        </div>


                                                        <div data-index="376" data-week="Tue" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">22</span>


                                                        </div>


                                                        <div data-index="377" data-week="Wed" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">23</span>


                                                        </div>


                                                        <div data-index="378" data-week="Thu" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">24</span>


                                                        </div>


                                                        <div data-index="379" data-week="Fri" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">25</span>


                                                        </div>


                                                        <div data-index="380" data-week="Sat" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">26</span>


                                                        </div>


                                                        <div data-index="381" data-week="Sun" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="382" data-week="Mon" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="383" data-week="Tue" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="384" data-week="Wed" data-month="Nov" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="swiper-slide" role="group" aria-label="12 / 12" style="width: 420px;">
                                                <div class="text-28 fw-500 text-center mb-10">December 2022</div>

                                                <div class="table-calendar js-calendar-single">
                                                    <div class="table-calendar__header">
                                                        <div>Sun</div>
                                                        <div>Mon</div>
                                                        <div>Tue</div>
                                                        <div>Wed</div>
                                                        <div>Thu</div>
                                                        <div>Fri</div>
                                                        <div>Sat</div>
                                                    </div>

                                                    <div class="table-calendar__grid overflow-hidden">

                                                        <div data-index="385" data-week="Sun" data-month="Nov" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="386" data-week="Mon" data-month="Nov" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="387" data-week="Tue" data-month="Nov" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="388" data-week="Wed" data-month="Nov" class="table-calendar__cell lh-1 text-light-1">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                        <div data-index="389" data-week="Thu" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">1</span>


                                                        </div>


                                                        <div data-index="390" data-week="Fri" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">2</span>


                                                        </div>


                                                        <div data-index="391" data-week="Sat" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">3</span>


                                                        </div>


                                                        <div data-index="392" data-week="Sun" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">4</span>


                                                        </div>


                                                        <div data-index="393" data-week="Mon" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">5</span>


                                                        </div>


                                                        <div data-index="394" data-week="Tue" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">6</span>


                                                        </div>


                                                        <div data-index="395" data-week="Wed" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">7</span>


                                                        </div>


                                                        <div data-index="396" data-week="Thu" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">8</span>


                                                        </div>


                                                        <div data-index="397" data-week="Fri" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">2</span>


                                                        </div>


                                                        <div data-index="398" data-week="Sat" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">3</span>


                                                        </div>


                                                        <div data-index="399" data-week="Sun" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">4</span>


                                                        </div>


                                                        <div data-index="400" data-week="Mon" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">5</span>


                                                        </div>


                                                        <div data-index="401" data-week="Tue" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">6</span>


                                                        </div>


                                                        <div data-index="402" data-week="Wed" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">7</span>


                                                        </div>


                                                        <div data-index="403" data-week="Thu" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">8</span>


                                                        </div>


                                                        <div data-index="404" data-week="Fri" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">9</span>


                                                        </div>


                                                        <div data-index="405" data-week="Sat" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">10</span>


                                                        </div>


                                                        <div data-index="406" data-week="Sun" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">11</span>


                                                        </div>


                                                        <div data-index="407" data-week="Mon" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">12</span>


                                                        </div>


                                                        <div data-index="408" data-week="Tue" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">13</span>


                                                        </div>


                                                        <div data-index="409" data-week="Wed" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">14</span>


                                                        </div>


                                                        <div data-index="410" data-week="Thu" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">15</span>


                                                        </div>


                                                        <div data-index="411" data-week="Fri" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">16</span>


                                                        </div>


                                                        <div data-index="412" data-week="Sat" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">17</span>


                                                        </div>


                                                        <div data-index="413" data-week="Sun" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">18</span>


                                                        </div>


                                                        <div data-index="414" data-week="Mon" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">19</span>


                                                        </div>


                                                        <div data-index="415" data-week="Tue" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">20</span>


                                                        </div>


                                                        <div data-index="416" data-week="Wed" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">21</span>


                                                        </div>


                                                        <div data-index="417" data-week="Thu" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">22</span>


                                                        </div>


                                                        <div data-index="418" data-week="Fri" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">23</span>


                                                        </div>


                                                        <div data-index="419" data-week="Sat" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">24</span>


                                                        </div>


                                                        <div data-index="420" data-week="Sun" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">25</span>


                                                        </div>


                                                        <div data-index="421" data-week="Mon" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">26</span>


                                                        </div>


                                                        <div data-index="422" data-week="Tue" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">27</span>


                                                        </div>


                                                        <div data-index="423" data-week="Wed" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">28</span>


                                                        </div>


                                                        <div data-index="424" data-week="Thu" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">29</span>


                                                        </div>


                                                        <div data-index="425" data-week="Fri" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">30</span>


                                                        </div>


                                                        <div data-index="426" data-week="Sat" data-month="Dec" class="table-calendar__cell lh-1 ">
                                                            <span class="js-date">31</span>


                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <button class="calendar-icon -left js-calendar-prev z-2 swiper-button-disabled" disabled="" tabindex="-1" aria-label="Previous slide" aria-controls="swiper-wrapper-dfb7cc993379136e" aria-disabled="true">
                                            <i class="icon-arrow-left text-24"></i>
                                        </button>

                                        <button class="calendar-icon -right js-calendar-next z-2" tabindex="0" aria-label="Next slide" aria-controls="swiper-wrapper-dfb7cc993379136e" aria-disabled="false">
                                            <i class="icon-arrow-right text-24"></i>
                                        </button>
                                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                                </div>
                            </div>
                        </div>


                        <div class="searchMenu-guests px-30 lg:py-20 lg:px-0 js-form-dd js-form-counters">

                            <div data-x-dd-click="searchMenu-guests">
                                <h4 class="text-15 fw-500 ls-2 lh-16">Guest</h4>

                                <div class="text-15 text-light-1 ls-2 lh-16">
                                    <span class="js-count-adult">2</span> adults
                                    -
                                    <span class="js-count-child">1</span> childeren
                                    -
                                    <span class="js-count-room">1</span> room
                                </div>
                            </div>


                            <div class="searchMenu-guests__field shadow-2" data-x-dd="searchMenu-guests" data-x-dd-toggle="-is-active">
                                <div class="bg-white px-30 py-30 rounded-4">
                                    <div class="row y-gap-10 justify-between items-center">
                                        <div class="col-auto">
                                            <div class="text-15 fw-500">Adults</div>
                                        </div>

                                        <div class="col-auto">
                                            <div class="d-flex items-center js-counter" data-value-change=".js-count-adult">
                                                <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">
                                                    <i class="icon-minus text-12"></i>
                                                </button>

                                                <div class="flex-center size-20 ml-15 mr-15">
                                                    <div class="text-15 js-count">2</div>
                                                </div>

                                                <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up">
                                                    <i class="icon-plus text-12"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-top-light mt-24 mb-24"></div>

                                    <div class="row y-gap-10 justify-between items-center">
                                        <div class="col-auto">
                                            <div class="text-15 lh-12 fw-500">Children</div>
                                            <div class="text-14 lh-12 text-light-1 mt-5">Ages 0 - 17</div>
                                        </div>

                                        <div class="col-auto">
                                            <div class="d-flex items-center js-counter" data-value-change=".js-count-child">
                                                <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">
                                                    <i class="icon-minus text-12"></i>
                                                </button>

                                                <div class="flex-center size-20 ml-15 mr-15">
                                                    <div class="text-15 js-count">1</div>
                                                </div>

                                                <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up">
                                                    <i class="icon-plus text-12"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-top-light mt-24 mb-24"></div>

                                    <div class="row y-gap-10 justify-between items-center">
                                        <div class="col-auto">
                                            <div class="text-15 fw-500">Rooms</div>
                                        </div>

                                        <div class="col-auto">
                                            <div class="d-flex items-center js-counter" data-value-change=".js-count-room">
                                                <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">
                                                    <i class="icon-minus text-12"></i>
                                                </button>

                                                <div class="flex-center size-20 ml-15 mr-15">
                                                    <div class="text-15 js-count">1</div>
                                                </div>

                                                <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up">
                                                    <i class="icon-plus text-12"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="button-item">
                            <button class="mainSearch__submit button -dark-1 py-15 px-35 h-60 col-12 rounded-4 bg-blue-1 text-white">
                                <i class="icon-search text-20 mr-10"></i>
                                Search
                            </button>
                        </div>
                    </div>
                </div>--}}
            </div>
        </div>
    </div>

    <div data-anim-child="fade" class="masthead__image is-in-view">
        <img src="{{ get_file_url($bg_image) }}" alt="image">
    </div>

</section>
