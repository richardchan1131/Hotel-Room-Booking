<div
    class="all-blocks flex-column h-100"
    :class="{'d-flex':showAddBlock,'d-none':!showAddBlock}"
>
    <div class="all-block-header flex-shrink-0 shadow-sm">
        <h5 @click="showAddBlock = false" class="modal-title font-weight-medium text-center px-3 py-2 d-flex align-items-center flex-shrink-0">
            <a href="#" class="px-3 lh-26 text-26 text-black border-right-1 border-right-solid border-right-gray mr-3">
                <i
                    class="fa fa-angle-left"
                ></i>
            </a>
            {{__("ADD LAYER")}}
        </h5>
    </div>
    <div class="p-2 flex-grow-1 overflow-auto">
        <input type="text" v-model="s" placeholder="{{__("Search block ...")}}" class="form-control mb-2">
        <hr>

        <div
            :key="index"
            v-for="(block,index) in filteredBlocks"
            class=""
            style="margin-bottom: 0px;border-radius: 0px;margin-top:-1px"
            v-show="block.items.length"
        >
            <div
                v-show="block.open"
                class=""
            >
                <div class="list-scrollable">
                    <div
                        class="block-panel"
                        v-for="item in block.items"
                    >
                        <div class="block-title">
                            @{{item.name}}
                            <div class="title-right">
                                                <span class="menu-add"><i
                                                        @click="addBlock(item)"
                                                        class="icon ion-ios-add-circle-outline"
                                                    ></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
