 <template>
    <div class="block-panel">
        <div class="block-title">
            <div>
                <div class="cursor-pointer btn btn-default mr-2"><i class=" fa fa-bars"></i></div>
                {{item.name}}
            </div>
            <div class="title-right">
                <span class="btn btn-light block-delete show-hover" @click="deleteBlock"><i class="icon ion-ios-trash"></i></span>
                <span class="btn btn-light block-edit" @click="openEdit"><i  class="icon ion-ios-build"></i></span>
            </div>
        </div>
        <div class="block-content p-2 px-3" v-if="labels.length">
            <div v-for="(label,index) in labels" :key="index">
                <div class="font-italic">{{label.label}}: {{label.value}}</div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                i18n:template_i18n
            }
        },
        props:{
            item:{},
            block:{},
            index:0
        },
        methods:{
            openEdit(){
                editBlockScreen.openEdit(this.item,this.block);

            },
            deleteBlock(){
                let c = confirm(this.i18n.delete_confirm);

                if(!c) return;

                this.$emit('delete',this.index);
            }
        },
        computed:{
            labels:function (){
                return this.block?.settings?.reduce((res,field)=>{
                    if(field.adminLabel){
                        const fieldClone = Object.assign({},field);
                        fieldClone.value = this.item?.model?.[field.id] || '';
                        if(fieldClone.value) {
                            res.push(fieldClone);
                        }
                    }
                    return res;
                },[]) || [];
            }
        }
    }
</script>
