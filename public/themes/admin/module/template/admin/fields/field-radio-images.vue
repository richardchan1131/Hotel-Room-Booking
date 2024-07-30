<template>
    <div class="bravo-template-radio-images">
        <div class="d-flex list-options">
            <div class="radio-item" :class="{selected:item.value == value}" v-for="(item,index) in items" :key="index" :title="item.name" @click="select(item)">
                <div class="radio-inner">
                    <div class="radio-name" v-if="item.name && schema.showOptionName !== false">{{item.name}}</div>
                    <div class="radio-image" v-if="item.image">
                        <img :src="item.image" :alt="item.name">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { abstractField } from "vue-form-generator";

    export default {
        mixins: [ abstractField ],
        data(){
            return {
                options:[],
                fakeModel:{
                    _active:false
                },
                template_i18n:template_i18n
            }
        },
        computed:{
            items() {
                let values = this.schema.values;
                if (typeof values == "function") {
                    return values.apply(this, [this.model, this.schema]);
                } else {
                    return values;
                }
            },
            selected(){
                return this.items.find((i)=>i.value == this.value);
            }
        },
        methods:{
            select(item){
                this.value = item.value
            }
        }
    };
</script>
