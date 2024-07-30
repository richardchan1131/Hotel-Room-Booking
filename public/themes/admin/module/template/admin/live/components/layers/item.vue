<template>
    <div class="layer-item" :class="{selected:selectedBlockId === id}">
        <div class=" layer-name d-flex justify-content-between align-items-center">
            <div
                class="drag-handler flex-grow-1"
                @click.prevent="selectBlock"
            >
                {{ block.name }}
            </div>
            <div class="dropdown" title="Options">
                <span data-toggle="dropdown" class="py-1 px-2">
                    <i class="fa fa-cog"></i>
                </span>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item text-danger" @click="deleteItem" href="#">Delete</a>
                </div>
            </div>
        </div>
        <div class="layer-children">
            <layer-item
                v-if="block.nodes"
                @select-block="emmitSelect" :selected-block-id="selectedBlockId" :items="items"
                v-for="(childId, index) in block.nodes"
                :key="index"
                :id="childId"
            ></layer-item>
        </div>
    </div>
</template>

<script>

export default {
    data: function () {
        return {
            i18n: template_i18n
        }
    },
    props: {
        items: {},
        id: '',
        selectedBlockId: '',
    },
    computed: {
        block() {
            return this.items[this.id] ?? {}
        }
    },
    methods: {
        selectBlock() {
            this.$emit('select-block', this.id);
        },
        emmitSelect(id) {
            this.$emit('select-block', id);
        },
        sortEnd(val) {
            console.log(val)
        },
        deleteItem() {
            if (!confirm(this.i18n.delete_confirm)) return;

            window.LiveEditorEventBus.$emit('delete-item', {
                id: this.id
            })
        }
    }
}
</script>
