<template>
    <div class="bravo-file-picker input-group">
        <input type="text" class="form-control" style="background: white" v-model="fileName" readonly :placeholder="i18n.choose_file">
        <div class="input-group-append" >
            <span class="input-group-text" @click="openUploader">{{i18n.browse}}</span>
            <span class="input-group-text text-danger" v-if="value" @click="clearFile">{{i18n.clear}}</span>
        </div>
    </div>
</template>
<script>
    export default {
        data:function () {
            return {
                file:{
                    file_name:'',
                    file_extension:'',
                },
                i18n:i18n
            }
        },
        props:{
            type:{
                default:'image'
            },
            value:''
        },
        computed:{
            fileName:function () {
                return this.file.file_extension ? this.file.file_name+'.'+this.file.file_extension : this.file.file_name;
            }
        },
        mounted(){
            var me = this;
            if(this.value){
                this.getFile(this.value);
            }
        },
        methods:{
            openUploader:function () {
                var me = this;
                uploaderModal.show({
                    multiple:false,
                    file_type:me.type,
                    onSelect:function (files) {
                        me.file = files[0];
                        me.$emit('input',me.file.id);
                    },
                });
            },
            clearFile:function () {
                this.file ={
                    file_name:'',
                    file_extension:'',
                };
                this.$emit('input','');
            },
            getFile(id){
                var me = this;
                this.file = {
                    file_name:'',
                    file_extension:'',
                };
                $.ajax({
                    url:bookingCore.media.get_file+'?id='+id,
                    dataType:'json',
                    success:function (json) {
                        if(json.id){
                            me.file = json;
                        }else{
                            me.file.file_name = '(ERROR: File not found)';
                            me.$emit('input','');
                        }
                    },
                    error:function (e) {
                        console.log(e);
                        me.file.file_name = '(ERROR: File not found)';
                        me.$emit('input','');
                    }
                })
            }
        },
        watch:{
            value:function(val){
                if(!val){
                    this.file = {
                        file_name:'',
                        file_extension:'',
                    };
                }else{
                    this.getFile(this.value);
                }
            }
        }

    }
</script>
