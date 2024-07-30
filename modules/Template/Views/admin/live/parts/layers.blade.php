<div
    id="live-layers"
    class="live-layers flex-column h-100"
    :class="{'d-flex':!showAddBlock,'d-none':showAddBlock}"
>
    <div class="text-center flex-shrink-0 shadow-sm">
        <h5 class="modal-title font-weight-medium text-center px-3 py-2 d-flex align-items-center flex-shrink-0">
            <svg width="16" height="16" class="mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                <path
                    class="a"
                    d="m14.144 9.969-4.92 3.414a.395.395 0 0 1-.45 0L3.857 9.969.929 12a.126.126 0 0 0 0 .205l7.925 5.5a.258.258 0 0 0 .292 0l7.925-5.5a.126.126 0 0 0 0-.205Z"
                ></path>
                <path
                    class="a"
                    d="M8.85 11.494.929 6a.124.124 0 0 1 0-.205L8.85.297a.265.265 0 0 1 .3 0l7.921 5.496a.124.124 0 0 1 0 .205L9.15 11.494a.265.265 0 0 1-.3 0Z"
                ></path>
            </svg>
            {{__("LAYERS")}}
        </h5>
    </div>
    <div class="flex-grow-1 overflow-auto mt-3">
        <draggable v-if="items.ROOT" v-model="items.ROOT.nodes" @change="sortEnd" handle=".drag-handler">
            <layer-item
                :selected-block-id="selectedBlockId" :items="items" v-for="(itemId, index) in items.ROOT.nodes" :key="index"
                :id="itemId"
                @select-block="selectBlock"
            ></layer-item>
        </draggable>
    </div>
    <div class="flex-shrink-0 p-2 border-top-1">
        <a href="#" class="btn btn-info btn-block" @click.prevent="showAddBlock = true"><i class="fa fa-plus"></i> {{__("Add layer")}}</a>
    </div>
</div>
