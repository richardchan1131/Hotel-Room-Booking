<div class="room-available pt-30 hotel_rooms_form">
    <div class="hotel_list_rooms" :class="{ 'loading': onLoadAvailability }">
        <div class="row">
            <div class="col-12">
                <div class="start_room_sticky"></div>
                <div class="room-item border-light rounded-4 px-30 py-30 sm:px-20 sm:py-20" :class="{ 'mt-20': index }"
                    v-for="(room,index) in rooms">
                    <h3 class="text-18 fw-500 mb-15">{{ room.title }}</h3>
                    <div class="roomGrid">
                        <div class="roomGrid__header">
                            <div><?php echo e(__('Room Type')); ?></div>
                            <div><?php echo e(__('Benefits')); ?></div>
                            <div><?php echo e(__('Select Rooms')); ?></div>
                        </div>
                        <div class="roomGrid__grid">
                            <div>
                                <div class="ratio ratio-1:1" @click="showGallery($event,room.id,room.gallery)">
                                    <img :src="room.image" alt="image" class="img-ratio rounded-4">
                                    <div class="count-gallery"
                                        v-if="typeof room.gallery !='undefined' && room.gallery && room.gallery.length > 1">
                                        <i class="fa fa-picture-o"></i>
                                        {{ room.gallery.length }}
                                    </div>
                                </div>

                                <a href="javascript:void(0)" class="d-block text-15 fw-500 underline text-blue-1 mt-15"
                                    @click="showGallery($event,room.id,room.gallery)"><?php echo e(__('Show Room Information')); ?></a>
                                <div class="modal" :id="'modal_room_' + room.id" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ room.title }}</h5>
                                                <span class="c-pointer" data-dismiss="modal" aria-label="Close">
                                                    <i class="input-icon field-icon fa">
                                                        <img src="<?php echo e(asset('images/ico_close.svg')); ?>" alt="close">
                                                    </i>
                                                </span>
                                            </div>
                                            <div class="modal-body">
                                                <div class="fotorama" data-nav="thumbs" data-width="100%"
                                                    data-auto="false" data-allowfullscreen="true">
                                                    <a v-for="g in room.gallery" :href="g.large"></a>
                                                </div>
                                                <div class="list-attributes">
                                                    <div class="attribute-item" v-for="term in room.terms">
                                                        <h4 class="title">{{ term.parent.title }}</h4>
                                                        <ul class="d-flex justify-content-between flex-wrap"
                                                            v-if="term.child">
                                                            <li v-for="term_child in term.child">
                                                                <i class="input-icon field-icon"
                                                                    v-bind:class="term_child.icon" data-toggle="tooltip"
                                                                    data-placement="top" :title="term_child.title"></i>
                                                                {{ term_child.title }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="roomGrid__content">
                                    <div class="room-type-item">
                                        <div class="room-attribute room-meta d-flex">
                                            <div class="item col-auto" v-if="room.size_html">
                                                <div class="tooltip -top h-50">
                                                    <div class="tooltip__text">
                                                        <i class="input-icon field-icon icofont-ruler-compass-alt"></i>
                                                        <span v-html="room.size_html"></span>
                                                    </div>
                                                    <div class="tooltip__content"><?php echo e(__('Room Footage')); ?></div>
                                                </div>
                                            </div>
                                            <div class="item col-auto" v-if="room.beds_html">
                                                <div class="tooltip -top h-50">
                                                    <div class="tooltip__text">
                                                        <i class="input-icon field-icon icofont-hotel"></i>
                                                        <span v-html="room.beds_html"></span>
                                                    </div>
                                                    <div class="tooltip__content"><?php echo e(__('No. Beds')); ?></div>
                                                </div>
                                            </div>
                                            <div class="item col-auto" v-if="room.adults_html">
                                                <div class="tooltip -top h-50">
                                                    <div class="tooltip__text">
                                                        <i class="input-icon field-icon icofont-users-alt-4"></i>
                                                        <span v-html="room.adults_html"></span>
                                                    </div>
                                                    <div class="tooltip__content"><?php echo e(__('No. Adults')); ?></div>
                                                </div>
                                            </div>
                                            <div class="item col-auto" v-if="room.children_html">
                                                <div class="tooltip -top h-50">
                                                    <div class="tooltip__text">
                                                        <i class="input-icon field-icon fa-child fa"></i>
                                                        <span v-html="room.children_html"></span>
                                                    </div>
                                                    <div class="tooltip__content"><?php echo e(__('No. Children')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div v-if="room.suplimentaryOlteanu">
                                            <div class="room-attribute mt-10">
                                                
                                                <div class="d-flex items-center" v-if="room.suplimentaryOlteanu.double_bed > 0">
                                                    <svg fill="#000000" width="23px" height="23px" class="ml-5"
                                                        viewBox="0 -11.47 122.88 122.88" version="1.1" id="Layer_1"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        style="enable-background:new 0 0 122.88 99.94"
                                                        xml:space="preserve">
                                                        <g>
                                                            <path
                                                                d="M4.22,67.36h114.31v-4.67c0-1.13-0.22-2.18-0.61-3.12c-0.42-1-1.04-1.89-1.81-2.66c-0.47-0.47-1-0.9-1.57-1.28 c-0.58-0.39-1.2-0.73-1.85-1.02c-1.75-0.38-3.49-0.74-5.22-1.08c-1.74-0.34-3.49-0.66-5.25-0.96c-0.08-0.01-0.14-0.02-0.22-0.04 c-0.89-0.15-1.74-0.29-2.55-0.42c-0.81-0.13-1.67-0.26-2.57-0.4l-0.02,0c-6.12-0.78-12.22-1.38-18.31-1.78 c-6.1-0.4-12.17-0.6-18.2-0.61c-3.58,0-7.15,0.06-10.72,0.2c-3.55,0.14-7.12,0.34-10.69,0.62l-0.02,0 c-3.34,0.31-6.67,0.7-10.01,1.15c-3.33,0.45-6.67,0.98-10.03,1.57l-0.37,0.09c-0.07,0.02-0.14,0.03-0.2,0.03 c-0.06,0.01-0.12,0.01-0.18,0.01c-1.57,0.28-3.18,0.59-4.84,0.92c-1.61,0.32-3.22,0.66-4.82,1.01c-0.4,0.22-0.78,0.47-1.14,0.73 c-0.36,0.27-0.71,0.56-1.02,0.87v0c-0.67,0.67-1.2,1.44-1.56,2.3c-0.34,0.81-0.53,1.71-0.53,2.69V67.36L4.22,67.36z M14.2,0h92.99 c1.21,0,2.37,0.24,3.43,0.68c1.1,0.46,2.09,1.13,2.92,1.95c0.83,0.83,1.5,1.82,1.95,2.92c0.44,1.06,0.68,2.22,0.68,3.43v42.69 c0.51,0.3,1.01,0.63,1.47,0.99c0.52,0.4,1.01,0.82,1.46,1.27c1.16,1.16,2.1,2.51,2.73,4.03c0.6,1.43,0.93,3.02,0.93,4.74v6.09 c0.03,0.1,0.06,0.2,0.08,0.3l0,0.02c0.02,0.13,0.03,0.25,0.03,0.37c0,0.13-0.01,0.26-0.04,0.39l0,0c-0.02,0.1-0.05,0.2-0.08,0.3 v27.66c0,0.58-0.24,1.11-0.62,1.49c-0.38,0.38-0.91,0.62-1.49,0.62h-4.35c-0.49,0-0.94-0.17-1.3-0.45 c-0.36-0.28-0.63-0.68-0.74-1.14c-0.8-2.3-1.61-4.12-2.48-5.54c-0.86-1.4-1.78-2.4-2.84-3.11c-1.07-0.71-2.35-1.16-3.9-1.43 c-1.58-0.28-3.42-0.37-5.61-0.36l-79.76,0.1l-0.04,0c-1.57-0.03-2.86,0.17-3.94,0.59c-1.07,0.42-1.94,1.05-2.66,1.86 c-0.81,0.9-1.49,2.05-2.11,3.39c-0.63,1.37-1.2,2.93-1.77,4.64l0,0c-0.14,0.44-0.42,0.79-0.77,1.04c-0.33,0.24-0.73,0.38-1.14,0.4 c-0.03,0.01-0.06,0.01-0.09,0.01H2.11c-0.58,0-1.11-0.24-1.49-0.62C0.24,98.94,0,98.41,0,97.83V61.52c0-1.57,0.3-3.01,0.84-4.31 c0.58-1.38,1.43-2.61,2.49-3.67c0.3-0.3,0.63-0.6,0.98-0.88c0.3-0.24,0.6-0.47,0.92-0.68V8.89c0-1.21,0.24-2.36,0.68-3.4 c0.46-1.09,1.13-2.07,1.96-2.89c0.83-0.82,1.82-1.47,2.91-1.92C11.84,0.24,12.99,0,14.2,0L14.2,0z M107.19,4.22H14.2 c-0.65,0-1.27,0.13-1.84,0.36c-0.59,0.24-1.11,0.59-1.55,1.02c-0.43,0.42-0.78,0.94-1.02,1.5C9.57,7.65,9.45,8.25,9.45,8.89v41.06 c0.3-0.1,0.6-0.18,0.91-0.26c0.49-0.13,0.98-0.24,1.47-0.32c0.68-0.12,1.42-0.25,2.22-0.39c0.6-0.1,1.24-0.21,1.9-0.31V38.19 c0-1.58,0.32-3.09,0.89-4.47c0.6-1.44,1.47-2.73,2.55-3.81c1.08-1.08,2.37-1.95,3.81-2.55c1.38-0.57,2.89-0.89,4.47-0.89h19.82 c1.58,0,3.09,0.32,4.47,0.89c1.44,0.6,2.73,1.47,3.81,2.55c1.08,1.08,1.95,2.37,2.55,3.81c0.57,1.38,0.89,2.89,0.89,4.47v6.69 c0.7-0.01,1.4-0.01,2.11-0.01v-6.68c0-1.58,0.32-3.09,0.89-4.47c0.6-1.44,1.47-2.73,2.55-3.81c1.08-1.08,2.37-1.95,3.81-2.55 c1.38-0.57,2.89-0.89,4.47-0.89h19.82c1.58,0,3.09,0.32,4.47,0.89c1.44,0.6,2.73,1.47,3.81,2.55c1.08,1.08,1.95,2.37,2.55,3.81 c0.57,1.38,0.89,2.89,0.89,4.47v10.34c0.75,0.11,1.55,0.24,2.41,0.38c0.95,0.15,1.86,0.3,2.74,0.45c0.45,0.08,0.91,0.17,1.37,0.28 c0.29,0.07,0.57,0.14,0.84,0.22V8.98c0-0.64-0.13-1.25-0.36-1.81c-0.24-0.58-0.6-1.1-1.04-1.55c-0.44-0.44-0.97-0.8-1.54-1.04 C108.44,4.35,107.83,4.22,107.19,4.22L107.19,4.22z M43.21,45.56c2.01-0.15,4.03-0.28,6.08-0.38c1.89-0.1,3.8-0.17,5.71-0.22v-6.77 c0-1.01-0.2-1.98-0.57-2.86c-0.38-0.92-0.94-1.74-1.64-2.44c-0.69-0.69-1.52-1.25-2.44-1.64c-0.88-0.37-1.85-0.57-2.86-0.57H27.67 c-1.01,0-1.98,0.2-2.86,0.57c-0.92,0.38-1.74,0.94-2.44,1.64c-0.69,0.69-1.25,1.52-1.64,2.44c-0.37,0.88-0.57,1.85-0.57,2.86V48 c1.62-0.24,3.26-0.46,4.94-0.68c1.81-0.23,3.61-0.44,5.39-0.64c0.69-0.08,1.43-0.17,2.2-0.25c0.72-0.08,1.47-0.15,2.27-0.23 c1.36-0.13,2.71-0.25,4.04-0.36C40.37,45.75,41.77,45.65,43.21,45.56L43.21,45.56z M65.54,44.9c1.21,0.02,2.42,0.05,3.63,0.09 c1.34,0.04,2.68,0.1,4.01,0.16l0.01,0c2.19,0.08,4.33,0.18,6.41,0.3c2.08,0.12,4.11,0.27,6.05,0.44c2.82,0.25,5.55,0.55,8.14,0.9 c2.32,0.32,4.52,0.68,6.58,1.08v-9.68c0-1.01-0.2-1.98-0.57-2.86c-0.38-0.92-0.94-1.74-1.64-2.44c-0.69-0.69-1.52-1.25-2.44-1.64 c-0.88-0.37-1.85-0.57-2.86-0.57H73.05c-1.01,0-1.98,0.2-2.86,0.57c-0.92,0.38-1.74,0.94-2.44,1.64c-0.69,0.69-1.25,1.52-1.64,2.44 c-0.37,0.88-0.57,1.85-0.57,2.86V44.9L65.54,44.9z M118.54,71.59H4.22v24.13h1.43c0.56-1.58,1.14-3.05,1.79-4.36 c0.7-1.4,1.49-2.64,2.45-3.71c1.14-1.28,2.48-2.27,4.09-2.93c1.61-0.65,3.49-0.98,5.75-0.93l79.69-0.1c2.57,0,4.77,0.12,6.69,0.49 c1.95,0.37,3.63,1,5.14,2c1.4,0.93,2.6,2.16,3.68,3.77c1.03,1.54,1.95,3.43,2.83,5.76h0.76V71.59L118.54,71.59z" />
                                                        </g>
                                                    </svg>
                                                    <div class="ml-10">
                                                        {{ room.suplimentaryOlteanu.double_bed }} <span
                                                            v-if="room.suplimentaryOlteanu.double_bed == 1"><?php echo e(__('dobule bed included.')); ?></span>
                                                        <span
                                                            v-if="room.suplimentaryOlteanu.double_bed > 1"><?php echo e(__('double beds included.')); ?></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="d-flex items-center" v-if="room.suplimentaryOlteanu.single_bed > 0">
                                                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                                        width="23px" height="23px"
                                                        viewBox="0 0 512.000000 512.000000" class="ml-5 "
                                                        preserveAspectRatio="xMidYMid meet">

                                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                            fill="#000000" stroke="none">
                                                            <path d="M1670 4226 c-146 -41 -257 -153 -296 -300 -11 -40 -14 -154 -14 -513
0 -440 -1 -463 -18 -463 -36 0 -143 -43 -202 -81 -110 -71 -178 -156 -229
-288 l-26 -66 -3 -753 -3 -752 25 -25 c33 -33 79 -33 111 0 24 23 25 29 25
160 l0 135 1520 0 1520 0 0 -135 c0 -131 1 -137 25 -160 32 -33 78 -33 111 0
l25 25 -3 752 -3 753 -26 66 c-38 98 -71 149 -140 218 -69 68 -166 122 -254
142 l-55 12 0 461 c0 353 -3 473 -14 511 -40 150 -151 261 -300 301 -71 19
-1707 19 -1776 0z m1780 -170 c49 -26 98 -74 123 -121 22 -39 22 -50 25 -507
l3 -468 -241 0 -240 0 0 136 c0 163 -10 200 -67 264 -71 79 -79 80 -491 80
-249 0 -367 -4 -396 -12 -26 -8 -60 -31 -91 -63 -66 -65 -75 -99 -75 -269 l0
-136 -240 0 -240 0 0 458 c0 438 1 459 21 502 33 73 94 128 169 151 14 4 403
7 865 6 798 -2 842 -3 875 -21z m-515 -801 c24 -23 25 -29 25 -160 l0 -135
-400 0 -400 0 0 135 c0 131 1 137 25 160 l24 25 351 0 351 0 24 -25z m917
-497 c91 -45 147 -103 191 -196 l32 -67 3 -247 4 -248 -1522 0 -1522 0 4 248
3 247 32 67 c17 37 50 87 72 111 44 48 135 101 197 116 23 5 534 9 1235 8
l1195 -2 76 -37z m228 -1118 l0 -200 -1520 0 -1520 0 0 200 0 200 1520 0 1520
0 0 -200z" />
                                                        </g>
                                                    </svg>

                                                    <div class="ml-10">
                                                        {{ room.suplimentaryOlteanu.single_bed }} <span
                                                            v-if="room.suplimentaryOlteanu.single_bed == 1"><?php echo e(__('single bed included.')); ?></span>
                                                        <span
                                                            v-if="room.suplimentaryOlteanu.single_bed > 1"><?php echo e(__('single beds included.')); ?></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="d-flex items-center"
                                                    v-if="room.suplimentaryOlteanu.sofa > 0">

                                                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                                        width="23px" height="23px"
                                                        viewBox="0 0 512.000000 512.000000" class="ml-5"
                                                        preserveAspectRatio="xMidYMid meet">
                                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                            fill="#000000" stroke="none">
                                                            <path d="M941 3916 c-51 -18 -106 -70 -132 -123 -22 -45 -24 -60 -24 -219 l0
-171 -45 15 c-63 19 -220 19 -300 -1 -119 -31 -243 -100 -331 -186 l-80 -77 6
-60 c3 -32 26 -400 51 -818 48 -809 47 -799 101 -848 25 -23 86 -48 117 -48
20 0 33 -16 78 -92 l54 -93 146 -3 147 -3 56 96 56 95 1719 0 1719 0 56 -95
56 -96 147 3 146 3 54 93 c45 76 58 92 78 92 31 0 92 25 117 48 54 48 53 39
101 848 25 417 48 786 51 819 l5 60 -79 77 c-131 127 -307 200 -481 202 l-85
1 0 145 c0 94 -5 158 -13 182 -22 62 -67 114 -123 142 l-53 26 -1640 -1
c-1262 0 -1649 -3 -1675 -13z m3316 -105 c26 -12 48 -32 59 -53 21 -39 30
-171 19 -282 l-7 -74 -65 -39 c-87 -51 -147 -119 -199 -228 -58 -121 -84 -225
-91 -367 -6 -113 -7 -117 -27 -113 -32 8 -438 43 -651 57 -253 16 -1187 17
-1455 0 -216 -13 -630 -49 -666 -57 -20 -4 -21 0 -27 108 -3 63 -15 149 -27
197 -29 115 -98 255 -158 321 -45 49 -50 61 -60 124 -27 177 -22 314 15 363
10 14 34 33 53 43 33 18 96 19 1640 19 1555 0 1606 -1 1647 -19z m-3493 -519
c36 -17 85 -51 110 -75 98 -98 166 -298 166 -486 l0 -107 -61 -43 c-33 -23
-62 -41 -65 -39 -2 3 -15 47 -28 99 -48 192 -119 323 -227 424 -98 90 -229
145 -347 145 -68 0 -60 13 33 59 140 69 301 78 419 23z m3942 6 c38 -14 89
-38 114 -54 l45 -29 -76 -6 c-42 -3 -93 -12 -115 -19 -152 -49 -281 -164 -358
-322 -42 -85 -96 -246 -96 -287 -1 -44 -16 -44 -80 0 l-62 44 4 135 c4 119 9
147 37 229 66 194 157 290 316 332 54 15 198 2 271 -23z m-4345 -198 c182 -34
326 -179 398 -400 53 -165 54 -173 58 -707 l4 -503 -274 0 c-261 0 -275 1
-292 20 -16 18 -23 96 -61 732 -23 392 -44 745 -46 783 l-3 70 40 6 c65 10
119 10 176 -1z m4609 -7 c4 -4 -14 -358 -40 -786 -42 -692 -49 -780 -65 -797
-17 -19 -32 -20 -292 -20 l-273 0 0 448 c0 573 12 672 106 868 81 170 198 266
364 298 36 7 192 -2 200 -11z m-1540 -497 c214 -17 489 -43 551 -52 20 -4 49
-17 65 -30 l29 -23 -1512 -1 c-832 0 -1513 2 -1513 4 0 3 13 14 30 26 23 16
59 25 157 35 158 18 484 43 703 55 262 13 1250 4 1490 -14z m770 -656 l0 -450
-1640 0 -1640 0 0 450 0 450 1640 0 1640 0 0 -450z m-3490 -566 c0 -3 -10 -23
-22 -44 l-23 -40 -81 0 -80 0 -22 39 c-12 21 -22 41 -22 45 0 3 56 6 125 6 69
0 125 -2 125 -6z m3950 0 c0 -4 -10 -24 -22 -45 l-22 -39 -80 0 -81 0 -22 40
c-13 21 -23 41 -23 44 0 4 56 6 125 6 69 0 125 -3 125 -6z" />
                                                        </g>
                                                    </svg>

                                                    <div class="ml-10">
                                                        {{ room.suplimentaryOlteanu.sofa }} <span
                                                            v-if="room.suplimentaryOlteanu.sofa == 1"><?php echo e(__('sofa included.')); ?></span>
                                                        <span
                                                            v-if="room.suplimentaryOlteanu.sofa > 1"><?php echo e(__('sofas included.')); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="room-attribute mt-10" v-if="room.number">
                                    <span style="margin-left: 50px;">
                                        <span class="price" v-html="room.price_html"></span>

                                    </span>
                                    <div class="d-flex items-center">
                                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="38px"
                                            height="38px" viewBox="0 0 512.000000 512.000000"
                                            style="margin-right: 4px;" preserveAspectRatio="xMidYMid meet">

                                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                fill="#000000" stroke="none">
                                                <path d="M1635 4595 c-248 -54 -422 -229 -471 -474 -50 -251 77 -515 306 -635
98 -51 171 -69 280 -69 164 0 306 58 420 174 116 116 173 256 173 419 0 192
-86 365 -236 477 -78 58 -145 88 -240 107 -90 19 -151 19 -232 1z" />
                                                <path d="M3255 4595 c-184 -40 -326 -146 -409 -305 -51 -98 -69 -171 -69 -280
0 -164 58 -306 174 -420 116 -116 256 -173 419 -173 202 0 381 94 493 260 162
239 132 549 -73 753 -144 145 -345 207 -535 165z" />
                                                <path d="M1157 3319 c-93 -22 -183 -95 -227 -184 l-25 -50 -3 -547 c-3 -593
-4 -577 52 -651 14 -19 50 -47 78 -63 46 -25 63 -28 131 -28 l77 0 0 -525 0
-526 28 -60 c52 -109 146 -168 267 -169 75 -1 148 25 192 66 l23 21 23 -21
c75 -71 218 -88 319 -39 61 30 105 74 140 140 l23 42 3 1048 2 1047 44 0 44 0
4 143 c5 158 19 212 84 308 19 28 34 53 34 55 0 2 -83 4 -185 4 -166 0 -190
-2 -225 -20 -82 -42 -188 -64 -310 -64 -122 1 -196 15 -302 60 -48 20 -73 24
-155 23 -54 -1 -115 -5 -136 -10z" />
                                                <path d="M2770 3314 c-96 -26 -175 -92 -219 -184 l-26 -55 -3 -530 c-2 -383 0
-542 9 -573 14 -51 77 -126 128 -151 49 -25 120 -35 164 -23 l36 10 3 -541 c3
-541 3 -542 26 -584 35 -66 79 -110 140 -140 101 -49 244 -32 319 39 l23 21
23 -21 c44 -41 117 -67 192 -66 121 1 210 57 265 166 l30 61 0 527 0 526 78 0
c67 0 84 3 130 28 28 16 64 44 78 63 56 74 55 58 52 651 l-3 547 -28 53 c-37
70 -91 123 -162 158 -52 25 -72 29 -174 32 -107 4 -121 2 -176 -21 -109 -46
-182 -60 -305 -61 -122 0 -228 22 -310 64 -32 16 -58 20 -137 19 -54 0 -123
-7 -153 -15z" />
                                            </g>
                                        </svg>

                                        <select v-if="room.number" v-model="room.number_selected"
                                            class="custom-select form-select w-100 rounded-4 border-light px-15 h-50 text-14">
                                            <option value="0">0</option>
                                            <option v-for="i in (1,room.number)" :value="i">
                                                {{ i + ' ' + (i > 1 ? i18n.rooms : i18n.room) }}
                                                &nbsp;&nbsp; ({{ formatMoney(i * room.price) }})</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="room-attribute mt-10" v-for="(child, childIndex) in children"
                                    v-if="room.childrenPrices.length">
                                    <span style="margin-left: 50px;">
                                        <?php echo e(__('Select children age')); ?>

                                    </span>
                                    <div class="d-flex items-center">
                                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="38px"
                                            height="38px" viewBox="0 0 512.000000 512.000000"
                                            style="margin-rigth: 4px;" preserveAspectRatio="xMidYMid meet">
                                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                fill="#000000" stroke="none">
                                                <path d="M3149 5107 c-97 -28 -202 -115 -249 -206 -119 -234 -48 -667 146
-889 46 -53 134 -112 166 -112 15 0 12 -11 -18 -69 -93 -184 -86 -367 34 -803
65 -234 85 -376 79 -548 -4 -108 -10 -164 -27 -220 -21 -75 -84 -204 -121
-249 l-20 -24 -27 25 c-24 22 -322 232 -472 331 l-55 37 -326 0 -326 0 -61
-30 c-72 -37 -170 -136 -225 -231 -96 -165 -160 -410 -188 -718 -10 -120 -10
-133 7 -167 36 -73 110 -97 182 -60 43 22 59 58 67 146 25 293 62 461 138 625
l32 69 5 -939 c5 -899 6 -942 24 -978 25 -51 84 -89 144 -94 63 -6 128 28 159
83 23 39 23 41 23 512 l0 472 35 0 35 0 0 -468 c0 -524 -3 -504 74 -567 33
-26 46 -30 101 -30 55 0 68 4 101 30 80 65 74 -16 74 1038 l0 938 123 -84 c67
-46 140 -96 161 -111 91 -61 205 -10 210 95 1 28 13 54 40 91 103 138 155 295
163 493 7 166 -12 289 -79 525 -120 421 -134 576 -68 752 32 87 58 118 116
139 135 50 253 233 316 487 29 116 31 309 4 397 -43 145 -133 254 -244 295
-70 27 -190 35 -253 17z" />
                                                <path d="M2201 3239 c-150 -29 -279 -166 -299 -316 -18 -135 22 -247 118 -336
80 -74 147 -100 261 -101 79 -1 90 2 161 37 193 95 269 311 179 504 -53 112
-154 189 -281 213 -60 11 -77 11 -139 -1z" />
                                            </g>
                                        </svg>
                                        <select v-if="room.childrenPrices" v-model="childrenPrices[childIndex]"
                                            @change="addChildrenDescription($event)" :key="room.id + 'roomchildren'"
                                            class="ml-10 custom-select form-select w-100 rounded-4 border-light px-15 h-50 text-14">
                                            <option v-for="chPrice in room.childrenPrices" :value="chPrice.price"
                                                :data-description="chPrice.minimum_age + ' - ' + chPrice.maximum_age">
                                                {{ chPrice.minimum_age }} - {{ chPrice.maximum_age }} <?php echo e(__('years old')); ?>

                                                {{ chPrice.price == 0 || chPrice.price === '0' ? 'gratuit' : formatMoney(chPrice.price) }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div v-if="room.suplimentaryOlteanu">
                                    <div class="room-attribute mt-10"
                                        v-if="room.suplimentaryOlteanu.breakfast_active || room.suplimentaryOlteanu.allinclusive_active || room.suplimentaryOlteanu.demipension_active">
                                        <span style="margin-left: 50px;">
                                            <?php echo e(__('Meals')); ?> <?php echo e(__('price per night')); ?>

                                        </span>
                                        <div class="d-flex items-center">
                                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="38px"
                                                height="38px" viewBox="0 0 512.000000 512.000000"
                                                style="margin-rigth: 4px;" preserveAspectRatio="xMidYMid meet">

                                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                    fill="#000000" stroke="none">
                                                    <path d="M4514 5081 c-263 -144 -457 -419 -573 -810 -88 -294 -140 -744 -120
-1035 21 -313 106 -653 262 -1045 l61 -154 156 6 c85 4 183 7 218 7 l62 0 0
1530 c0 842 -3 1530 -7 1530 -5 0 -31 -13 -59 -29z" />
                                                    <path d="M673 4460 c-22 -13 -35 -31 -42 -57 -6 -21 -29 -313 -52 -650 l-42
-612 26 -38 c15 -21 92 -121 172 -223 163 -206 193 -256 203 -337 4 -31 0
-455 -10 -942 -9 -487 -17 -996 -17 -1131 -1 -236 0 -246 22 -285 76 -135 298
-135 374 0 22 39 23 49 22 280 0 132 -8 641 -17 1131 -9 490 -14 916 -10 947
4 31 18 78 32 104 14 26 104 148 200 271 97 123 176 231 176 240 -1 9 -22 298
-49 641 -48 616 -49 623 -73 647 -13 14 -40 27 -61 31 -31 5 -40 1 -67 -25
-39 -39 -39 -21 5 -692 19 -294 35 -556 35 -583 l0 -48 -142 3 -143 3 -5 648
-5 649 -28 24 c-34 29 -62 30 -104 4 -18 -11 -34 -21 -35 -22 -2 -2 -5 -295
-8 -653 l-5 -650 -142 -3 -143 -3 0 58 c1 32 18 317 39 633 41 627 41 629 -14
650 -38 14 -56 12 -92 -10z" />
                                                    <path d="M2588 4361 c-80 -26 -143 -65 -217 -135 -304 -290 -372 -858 -153
-1281 65 -125 186 -249 293 -300 274 -130 557 0 721 330 176 354 151 821 -61
1133 -151 222 -375 319 -583 253z" />
                                                    <path d="M2550 2509 c1 -19 -12 -550 -26 -1181 l-28 -1147 30 -58 c42 -81 102
-118 193 -118 99 1 173 51 208 143 16 41 15 109 -11 1215 -16 645 -29 1173
-31 1175 -1 1 -14 -2 -29 -8 -67 -25 -218 -21 -293 7 -9 4 -13 -5 -13 -28z" />
                                                    <path
                                                        d="M4150 985 l0 -985 215 0 215 0 0 985 0 985 -215 0 -215 0 0 -985z" />
                                                </g>
                                            </svg>
                                            <select v-model="meals" @change="addMealsDescription($event)"
                                                class="ml-10 custom-select form-select w-100 rounded-4 border-light px-15 h-50 text-14">
                                                <option selected value="0">
                                                    <?php echo e(__('Select meals')); ?>

                                                </option>
                                                <option v-bind:value="room.suplimentaryOlteanu.breakfast_price"
                                                    v-if="room.suplimentaryOlteanu.breakfast_active "
                                                    data-description="<?php echo e(__('Breakfast')); ?>">
                                                    <?php echo e(__('Breakfast')); ?> {{ formatMoney(room.suplimentaryOlteanu.breakfast_price) }}
                                                </option>
                                                <option v-bind:value="room.suplimentaryOlteanu.demipension_price"
                                                    v-if="room.suplimentaryOlteanu.demipension_active "
                                                    data-description="<?php echo e(__('Demipension')); ?>">
                                                    <?php echo e(__('Demipension')); ?> {{ formatMoney(room.suplimentaryOlteanu.demipension_price) }}
                                                </option>
                                                <option v-bind:value="room.suplimentaryOlteanu.allinclusive_price"
                                                    data-description="<?php echo e(__('All-Inclusive')); ?>"
                                                    v-if="room.suplimentaryOlteanu.allinclusive_active ">
                                                    <?php echo e(__('All-Inclusive')); ?> {{ formatMoney(room.suplimentaryOlteanu.allinclusive_price) }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="room-attribute mt-10"
                                        v-if="room.suplimentaryOlteanu.freecancelation_active">
                                        <span style="margin-left: 50px;">
                                            <?php echo e(__('Free cancelation')); ?>

                                        </span>
                                        <div class="d-flex items-center">
                                            <svg fill="#000000" width="38px" height="38px" viewBox="0 0 24 24"
                                                style="margin-rigth: 4px;" id="Layer_1"
                                                data-name="Layer 1" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14,13a2,2,0,1,1-3-1.723V7a1,1,0,0,1,2,0v4.277A1.994,1.994,0,0,1,14,13Zm6.06-7.461a11,11,0,1,1-16.12,0l-.672-.747A3.672,3.672,0,0,1,2,5,1,1,0,0,1,2,3c.785,0,1-.215,1-1A1,1,0,0,1,5,2a3.513,3.513,0,0,1-.28,1.417l.706.784A10.923,10.923,0,0,1,11,2.051V1a1,1,0,0,1,2,0V2.051A10.923,10.923,0,0,1,18.574,4.2l.706-.784A3.513,3.513,0,0,1,19,2a1,1,0,0,1,2,0c0,.785.215,1,1,1a1,1,0,0,1,0,2,3.672,3.672,0,0,1-1.268-.208ZM21,13a9,9,0,1,0-9,9A9.01,9.01,0,0,0,21,13Z" />
                                            </svg>
                                            <select v-model="freecancelation"
                                                class="ml-10 custom-select form-select w-100 rounded-4 border-light px-15 h-50 text-14">
                                                <option selected value="0">
                                                    <?php echo e(__('Without freecancelation')); ?>

                                                </option>
                                                <option v-bind:value="room.suplimentaryOlteanu.freecancelation_price"
                                                    v-if="room.suplimentaryOlteanu.freecancelation_active ">
                                                    <?php echo e(__('With freecancelation')); ?> {{ formatMoney(room.suplimentaryOlteanu.freecancelation_price) }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="room-attribute mt-10"
                                        v-if="room.suplimentaryOlteanu.additional_bed_active">
                                        <span style="margin-left: 50px;">
                                            <?php echo e(__('Supplymentary bed')); ?> (<span
                                                v-html="formatMoney(room.suplimentaryOlteanu.additional_bed_price)"></span>)
                                        </span>
                                        <div class="d-flex items-center">
                                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="38px"
                                                height="38px" viewBox="0 0 512.000000 512.000000"
                                                style="margin-right: 4px;" preserveAspectRatio="xMidYMid meet">

                                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                    fill="#000000" stroke="none">
                                                    <path d="M1670 4226 c-146 -41 -257 -153 -296 -300 -11 -40 -14 -154 -14 -513
0 -440 -1 -463 -18 -463 -36 0 -143 -43 -202 -81 -110 -71 -178 -156 -229
-288 l-26 -66 -3 -753 -3 -752 25 -25 c33 -33 79 -33 111 0 24 23 25 29 25
160 l0 135 1520 0 1520 0 0 -135 c0 -131 1 -137 25 -160 32 -33 78 -33 111 0
l25 25 -3 752 -3 753 -26 66 c-38 98 -71 149 -140 218 -69 68 -166 122 -254
142 l-55 12 0 461 c0 353 -3 473 -14 511 -40 150 -151 261 -300 301 -71 19
-1707 19 -1776 0z m1780 -170 c49 -26 98 -74 123 -121 22 -39 22 -50 25 -507
l3 -468 -241 0 -240 0 0 136 c0 163 -10 200 -67 264 -71 79 -79 80 -491 80
-249 0 -367 -4 -396 -12 -26 -8 -60 -31 -91 -63 -66 -65 -75 -99 -75 -269 l0
-136 -240 0 -240 0 0 458 c0 438 1 459 21 502 33 73 94 128 169 151 14 4 403
7 865 6 798 -2 842 -3 875 -21z m-515 -801 c24 -23 25 -29 25 -160 l0 -135
-400 0 -400 0 0 135 c0 131 1 137 25 160 l24 25 351 0 351 0 24 -25z m917
-497 c91 -45 147 -103 191 -196 l32 -67 3 -247 4 -248 -1522 0 -1522 0 4 248
3 247 32 67 c17 37 50 87 72 111 44 48 135 101 197 116 23 5 534 9 1235 8
l1195 -2 76 -37z m228 -1118 l0 -200 -1520 0 -1520 0 0 200 0 200 1520 0 1520
0 0 -200z" />
                                                </g>
                                            </svg>
                                            <select v-model="additional_bed"
                                                class="ml-10 custom-select form-select w-100 rounded-4 border-light px-15 h-50 text-14">
                                                <option v-bind:value="room.suplimentaryOlteanu.additional_bed_price">
                                                    <?php echo e(__('Yes')); ?>

                                                </option>
                                                <option value="false">
                                                    <?php echo e(__('No')); ?>

                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hotel_room_book_status" v-if="total_price">
        <div class="row row_extra_service" v-if="extra_price.length">
            <div class="col-md-12">
                <div class="form-section-group">
                    <label><?php echo e(__('Extra prices:')); ?></label>
                    <div class="row">
                        <div class="col-md-6 extra-item" v-for="(type,index) in extra_price">
                            <div class="extra-price-wrap d-flex align-items-center justify-content-between">
                                <div class="flex-grow-1">
                                    <label class="d-flex items-center">
                                        <span class="form-checkbox ">
                                            <input type="checkbox" true-value="1" false-value="0" class="has-value"
                                                style="display: none;" v-model="type.enable">
                                            <span class="form-checkbox__mark"><span
                                                    class="form-checkbox__icon icon-check"></span></span>
                                        </span>
                                        <span class="text-15 ml-10"
                                            style="line-height: 1">{{ type.name }}</span>
                                        <div class="render" v-if="type.price_type">({{ type.price_type }})</div>
                                    </label>
                                </div>
                                <div class="flex-shrink-0">{{ type.price_html }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row_total_price">
            <div class="col-sm-12 col-md-6" style="border-right: 1px solid #ccc">
                <div class="extra-price-wrap d-flex justify-content-between">
                    <div class="flex-grow-1">
                        <label>
                            <?php echo e(__('Total Room')); ?>:
                        </label>
                    </div>
                    <div class="flex-shrink-0">
                        {{ total_rooms }}
                    </div>
                </div>
                <div class="extra-price-wrap d-flex justify-content-between" v-for="(type,index) in buyer_fees">
                    <div class="flex-grow-1">
                        <label>
                            {{ type.type_name }}
                            <span class="render" v-if="type.price_type">({{ type.price_type }})</span>
                            <div class="tooltip -top d-inline-block" v-if="type.desc">
                                <div class="tooltip__text"><i class="input-icon field-icon icofont-info-circle"></i>
                                </div>
                                <div class="tooltip__content"
                                    style="width: 230px; left: 50%; transform: translateX(-50%);">
                                    {{ type.type_desc }}</div>
                            </div>
                        </label>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="unit" v-if='type.unit == "percent"'>
                            {{ type.price }}%
                        </div>
                        <div class="unit" v-else>
                            {{ formatMoney(type.price) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="control-book text-right">
                    <div class="row">
                        <div class="col-6">
                            <div style="font-size:23px; font-weight:500;color:#ff3f19;">
                                <span style="color: #000; font-size: 16px; font-weight: 500;">
                                    <?php echo e(__('Total Price')); ?>:</span> {{ total_price_html }}
                            </div>
                            <div v-if="is_deposit_ready" class="font-weight-bold"
                                style="font-size:23px; font-weight:500;color:#ff3f19;">
                                <span
                                    style="color: #000; font-size: 16px; font-weight: 500;"><?php echo e(__('Pay now')); ?></span>
                                {{ pay_now_price_html }}
                            </div>
                        </div>
                        <div class="col-6">
                            <button type="button"
                                class="button -dark-1 py-15 px-35 rounded-4 bg-blue-1 text-white cursor-pointer d-inline-block"
                                @click="doSubmit($event)" :class="{ 'disabled': onSubmit }" name="submit">
                                <span><?php echo e(__('Book Now')); ?></span>
                                <i v-show="onSubmit" class="fa fa-spinner fa-spin"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="end_room_sticky"></div>
    <div class="alert alert-warning" v-if="!firstLoad && !rooms.length">
        <?php echo e(__('No room available with your selected date. Please change your search critical')); ?>

    </div>
</div>
<?php /**PATH /home/r114961reze/public_html/custom/Hotel/Views/frontend/layouts/details/hotel-room-list.blade.php ENDPATH**/ ?>