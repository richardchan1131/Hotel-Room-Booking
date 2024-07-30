<template>
    <div
        :id="'block-'+id" class="live-block-preview" @click="selectBlock" :class="{selected:selectedBlockId === id,selectable:id !==
    'ROOT'}"
    >
        <div class="block-info">
            <div>{{ block.name }}</div>
        </div>
        <div
            class="block-preview"
            v-html="block.preview"
        ></div>
        <div class="live-block-children" v-if="block.nodes && block.nodes.length">
            <live-preview-item
                v-for="(childId,index) in block.nodes"
                :key="index"
                :items="items"
                :id="childId"
                :selected-block-id="selectedBlockId"
            />
        </div>
    </div>
</template>
<script>
export default {
    name: 'live-preview-item',
    data: function () {
        return {}
    },
    props: {
        items: {
            type: Object,
        },
        id: {
            type: String
        },
        selectedBlockId: ''
    },
    computed: {
        block() {
            return this.items[this.id] ?? {
                nodes: []
            }
        }
    },
    methods: {
        selectBlock(e) {
            e.stopPropagation();
            if (this.id === 'ROOT') return;
            window.LiveEventBus.$emit('select-item', this.id);
        },
    }
}
</script>
