import Vue from 'vue'
import BlockPreview from './components/block-preview'

window.LiveEventBus = new Vue({});

window.LivePreview = new Vue({
    el: '#live-preview',
    data: {
        items: current_template_items,
        message: {
            content: '',
            type: false
        },
        onSaving: false,
        s: '',
        selectedBlockId: ''
    },
    mounted() {
        this.$nextTick(() => {
            window.addEventListener('message', message => {
                // ...
                if (message?.data?.action) {
                    switch (message?.data?.action) {
                        case "set_items":
                            this.setItems(message?.data?.data)
                            break;
                        case "select-item":
                            $('body,html').animate({
                                scrollTop: document.getElementById("block-" + message.data.data).offsetTop
                            }, 'fast')
                            this.selectedBlockId = message.data.data;
                            break;
                        case "save_block":
                            this.updateBlock(message.data.data.id, message.data.data.model)
                            break;
                        case 'sort-end':
                            this.sortEndFromParent(message.data.data)
                            break;
                        case 'delete-item':
                            this.deleteItemFromParent(message.data.data)
                            break;
                        case 'add-item':
                            this.addItemFromParent(message.data.data)
                            break;
                    }
                }
            });

        })
    },
    created() {
        LiveEventBus.$on('select-item', (id) => {
            this.selectItem(id);
        });
    },
    methods: {
        setItems(items) {
            this[items] = items;
        },
        selectItem(id) {
            this.selectedBlockId = id;
            window.parent.postMessage({
                'action': 'select-item',
                data: {
                    id
                }
            }, "*");
        },
        updateBlock(id, model) {
            // Ajax upload model HTML
            this.$set(this.items, id, {
                ...this.items[id],
                model
            })
            this.items[id].onLoading = true;

            $.ajax({
                url: preview_routes.preview,
                method: 'post',
                dataType: 'json',
                data: {
                    block: this.items[id].type,
                    model
                },
                success: (json) => {
                    this.items[id].onLoading = false;
                    if (json.preview) {
                        this.items[id].preview = json.preview;
                        this.$nextTick(() => {
                            $(document).
                                trigger('preview-updated',
                                    {id, type: this.items[id].type, json});
                        });

                    }
                },
                error: () => {
                    this.items[id].onLoading = false;
                }
            })

        },
        sortEndFromParent(data) {
            const itemId = data.element;
            const movedTo = data.newIndex;
            const moveFrom = data.oldIndex;

            const parent = this.items.ROOT.nodes;
            parent.splice(moveFrom, 1);
            parent.splice(movedTo, 0, itemId);

            this.items.ROOT.nodes = parent;
        },
        deleteItemFromParent(data) {
            const itemId = data.id;
            const itemObj = this.items[itemId];
            if (typeof itemObj !== 'undefined') {
                const parentNodes = this.items[itemObj.parent].nodes;
                if (typeof parentNodes !== 'undefined' && parentNodes.indexOf(itemId) !== -1) {
                    this.items[itemObj.parent].nodes.splice(parentNodes.indexOf(itemId), 1);
                }
                delete this.items[itemId];
            }
        },
        addItemFromParent(data) {
            const {parentId, newId, blockParams} = data;
            this.addBlockTo(parentId, newId, blockParams)
            this.$nextTick(() => {
                this.updateBlock(newId, blockParams.model);
            })
        },
        addBlockTo(parentId, newId, blockParams) {
            if (!this.items[parentId]) return;
            this.items[parentId].nodes.push(newId);
            this.$set(this.items, newId, blockParams);
        },
        scrollToItem(id) {
            $('body,html').animate({
                scrollTop: document.getElementById("block-" + id).offsetTop
            }, 'fast')
        },
        showAddLayer(){
            window.parent.postMessage({
                'action': 'show-add-layer',
            }, "*");
        }

    },
    components: {
        LivePreviewItem: BlockPreview
    }
})
$('a').on('click', function (e) {
    e.preventDefault();
})
