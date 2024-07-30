import Vue from "vue";
import Form from './components/form'
import LayerItem from './components/layers/item'
import draggable from 'vuedraggable';

export default function () {
    window.LiveEditorEventBus = new Vue({})
    window.LiveEditor = new Vue({
        el: '#live-editor',
        data: {
            items: current_template_items,
            blocks: [],
            message: {
                content: '',
                type: false
            },
            onSaving: false,
            s: '',
            selectedBlockId: '',
            frame: null,
            showAddBlock: false,
            lastSaved:current_last_saved
        },
        mounted() {
            var me = this;
            this.reloadBlocks();

            this.$nextTick(function () {
                me.frame = document.getElementById('frame-preview').contentWindow;
                window.addEventListener('message', message => {
                    if (message.source !== me.frame) {
                        return; // Skip message in this event listener
                    }
                    console.log(message)
                    // ...
                    if (message?.data?.action) {
                        switch (message?.data?.action) {
                            case "select-item":
                                me.selectItemFromFrame(message?.data?.data.id)
                                break;
                            case "show-add-layer":
                                me.showAddBlock = true;
                                break;
                        }
                    }
                });

                me.frame.postMessage({
                    'action': 'set_items',
                    data: me.items
                }, "*")
            })


            window.LiveEditorEventBus.$on('delete-item', (data) => {
                this.deleteItem(data)
            })
        },
        computed: {
            filteredBlocks: function () {
                const res = {};
                if (!this.s) return this.blocks;

                Object.entries(this.blocks).forEach(([groupId, group]) => {
                    res[groupId] = Object.assign({}, group);
                    res[groupId].items = group.items.filter((item) => {
                        return item.name.toLowerCase().includes(this.s.toLowerCase());
                    }) || [];
                })
                return res;
            },
            blocksMapById() {
                let res = {};
                Object.entries(this.blocks).forEach(([, group]) => {
                    group.items.forEach((item) => {
                        res[item.id] = item;
                    })
                })
                return res
            },
            currentModel() {
                return this.items[this.selectedBlockId].model ?? {}
            },
            currentBlockSetting() {
                return this.blocksMapById[this.items[this.selectedBlockId].type] ?? {}
            }
        },
        methods: {
            reloadBlocks() {
                var me = this;

                jQuery.ajax({
                    url: bookingCore.admin_url + '/module/template/getBlocks',
                    dataType: 'json',
                    type: 'get',
                    success: function (res) {
                        if (res.status) {
                            me.blocks = res.data
                        }
                    },
                    error: function (e) {
                        console.log(e);

                    }
                })
            },
            selectBlock(id) {
                this.selectedBlockId = id;

                this.frame.postMessage({
                    'action': 'select-item',
                    data: id
                }, "*")
            },
            selectItemFromFrame(id) {
                this.selectedBlockId = id;
            },
            saveTemplate() {
                var me = this;

                this.onSaving = true;

                $.ajax({
                    url: bookingCore.admin_url + '/module/template/store',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        id: template_id,
                        content: JSON.stringify(this.items),
                        title: this.title,
                        lang: current_menu_lang
                    },
                    success: function (res) {
                        me.onSaving = false;
                        me.lastSaved = res.lastSaved
                        if (res.message) {
                            me.message.content = res.message;
                            me.message.type = res.status;
                        }
                        if (res.url) {
                            window.location.href = res.url;
                        }

                        window.setTimeout(()=>{
                            me.message.content = '';
                        },3000)
                    },
                    error: function (e) {
                        me.onSaving = false;

                        if (e.responseJSON.message) {
                            me.message.content = e.responseJSON.message;
                            me.message.type = false;
                        } else {

                            me.message.content = 'Can not save menu';
                            me.message.type = false;
                        }

                    }
                })
            },
            cancelEdit() {
                this.selectedBlockId = '';
            },
            saveBlock(model) {
                if (this.selectedBlockId && this.items[this.selectedBlockId]) {
                    this.$set(this.items, this.selectedBlockId, {
                        ...this.items[this.selectedBlockId],
                        model
                    })
                    this.frame.postMessage({
                        'action': 'save_block',
                        data: {
                            id: this.selectedBlockId,
                            model
                        }
                    }, "*")
                    this.saveTemplate()
                }
            },
            sortEnd(val) {
                this.saveTemplate();
                this.frame.postMessage({
                    'action': 'sort-end',
                    data: val.moved
                }, "*")
            },
            deleteItem(data) {
                const itemId = data.id;
                const itemObj = this.items[itemId];
                if (typeof itemObj !== 'undefined') {
                    const parentNodes = this.items[itemObj.parent].nodes;
                    if (typeof parentNodes !== 'undefined' && parentNodes.indexOf(itemId) !== -1) {
                        this.items[itemObj.parent].nodes.splice(parentNodes.indexOf(itemId), 1);
                    }
                    delete this.items[itemId];

                    this.frame.postMessage({
                        'action': 'delete-item',
                        data
                    }, "*")
                    this.saveTemplate();
                }
            },
            addBlock(block) {
                this.addBlockTo('ROOT', block);
            },
            addBlockTo(parentId, block) {
                const newId = this.makeid(20);
                const blockParams = this.getBlockParams(block);
                blockParams.parent = parentId;

                if (!this.items[parentId]) return;
                this.items[parentId].nodes.push(newId);
                this.$set(this.items, newId, blockParams);

                this.frame.postMessage({
                    'action': 'add-item',
                    data: {
                        parentId,
                        newId,
                        blockParams
                    }
                }, "*")

                this.$nextTick(() => {
                    this.selectBlock(newId);
                    this.showAddBlock = false;
                })

            },
            getBlockParams(block) {
                let res = {
                    type: block.id,
                    name: block.name,
                    model: block.model,
                    component: block.component,
                    open: true
                }

                if (block.is_container) {
                    res.is_container = true;
                    res.children = [];
                }

                return res;
            },
            makeid(length) {
                let result = '';
                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                const charactersLength = characters.length;
                let counter = 0;
                while (counter < length) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                    counter += 1;
                }
                return result.toLowerCase();
            }
        },
        components: {
            BlockForm: Form,
            LayerItem,
            draggable
        }
    })
}
