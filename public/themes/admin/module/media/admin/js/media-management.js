import Vue from 'vue';
export default function(){
    window.mediaManagement = new Vue({
        el: '#media-management',
        data:{
            files:[],
            viewType:'grid',
            total:0,
            totalPage:0,
            fileTypes:[],
            selected:[],
            selectedLists:[],
            showUploader:false,
            apiFinished:false,
            modalEl:false,
            multiple:true,
            isLoading:false,
            filter:{
                page:1
            },
            onSelect:function () {

            },
            uploadConfigs:{
                file_type:'default'
            },
            currentFolder:{
                id:0,
                onEdit:false
            },
            folders:[],
            breadcrumbs:[],
            accept_type:bookingCore.media.groups.default.mime.join(',')
        },
        mounted(){
            let me = this;
            me.reloadLists();
            me.reloadFolder();

            this.$nextTick(function () {
                $(this.$refs.files).change(function () {
                    me.upload(this.files)
                })
            })

            if(window.localStorage){
                const type = window.localStorage.getItem('bc_media_view_type');
                if(type){
                    this.viewType = type;
                }
            }

        },
        watch:{
            uploadConfigs(val){
                this.multiple = val.multiple;
                this.onSelect = val.onSelect;
            }
        },
        methods:{
            deletedFolder:function (index){
                this.folders.splice(index,1);
            },
            setViewType:function (type){
                this.viewType = type;
                if(window.localStorage){
                    window.localStorage.setItem('bc_media_view_type',type);
                }
            },
            toggleEditFolder:function (index,val){
                this.$set(this.folders[index],'onEdit',val);
            },
            reloadAll:function (){
                this.filter.page = 1;
                this.reloadLists();
                this.reloadFolder();
            },
            toFolderRoot:function (){
                this.breadcrumbs = [];
                this.currentFolder = {
                    id:0,
                    parent_id:0
                }
                this.filter.page = 1;
                this.reloadLists();
                this.reloadFolder();
            },
            showFolder:function (folder,index){
                if(folder.id === this.currentFolder.id) return;

                this.breadcrumbs.push(folder);
                if(typeof index != 'undefined'){
                    this.breadcrumbs.splice(index,this.breadcrumbs.length - 1 - index)
                }
                this.currentFolder = folder;
                this.filter.page = 1;
                this.reloadLists();
                this.reloadFolder();
            },
            updateFolder:function (index,folder){
                this.$set(this.folders,index,Object.assign({},folder));
            },
            addFolder:function (){
                this.folders.push({
                    id:0,
                    name:'New Folder',
                    onEdit:true,
                    parent_id:this.currentFolder.id
                });
            },
            reloadFolder:function(){
                var me = this;
                $.ajax({
                    url:bookingCore.url+'/media/folder',
                    type:'get',
                    data:{
                        parent_id:this.currentFolder.id,
                    },
                    dataType:'json',
                    success:function (json) {
                        me.folders = json.data;
                    }
                });
            },
            show(configs){
                this.files = [];
                this.resetSelected();
                this.uploadConfigs = configs;
                this.modalEl.modal('show');
            },
            hide(){
                this.modalEl.modal('hide');
            },
            changePage(p,e){
                e.preventDefault();
                this.filter.page = p;
                this.reloadLists();
            },
            selectFile(file){
                var index = this.selected.indexOf(file.id);
                if (index > -1) {
                    this.selected.splice(index, 1);
                    this.selectedLists.splice(index,1);
                }else{
                    if(!this.multiple){
                        this.selected = [];
                        this.selectedLists = [];
                    }
                    this.selected.push(file.id);
                    this.selectedLists.push(file);
                }
            },
            removeFiles() {
                var me = this;
                bookingCoreApp.showConfirm({
                    message: i18n.confirm_delete,
                    callback: function(result){
                        if(result){
                            me.isLoading = true;
                            $.ajax({
                                url:bookingCore.admin_url+'/module/media/removeFiles',
                                type:'POST',
                                data:{
                                    file_ids : me.selected
                                },
                                dataType:'json',
                                success:function (data) {
                                    if(data.status === 1){
                                        //bookingCoreApp.showSuccess(data);
                                    }
                                    if(data.status === 0){
                                        bookingCoreApp.showError(data);
                                    }
                                    me.isLoading = false;
                                    me.reloadLists();
                                },
                                error:function (e) {
                                    me.isLoading = false;
                                    bookingCoreApp.showAjaxError(e);
                                    me.resetSelected();
                                }
                            });
                        }
                    }
                })
            },
            sendFiles(){
                if(typeof this.onSelect == 'function'){
                    let f = this.onSelect;
                    f(this.selectedLists)
                }
                this.hide();
            },
            init(){
                var me = this;
                this.reloadLists();
            },
            reloadLists(){
                var me = this;
                $("#cdn-browser .icon-loading").addClass("active");
                me.isLoading = true;
                $.ajax({
                    url:bookingCore.admin_url+'/module/media/getLists',
                    type:'POST',
                    data:{
                        file_type:this.uploadConfigs.file_type,
                        page:this.filter.page,
                        s:this.filter.s,
                        folder_id:this.currentFolder.id
                    },
                    dataType:'json',
                    success:function (json) {
                        me.resetSelected();
                        me.files = json.data;
                        me.total = json.total;
                        me.totalPage = json.totalPage;
                        me.isLoading = false;
                        me.apiFinished = true;
                    }
                });
            },
            upload(files){
                var me = this;
                if(!files.length) return ;
                console.log(files);
                for(var i = 0; i < files.length ; i++){
                    var d = new FormData();
                    d.append('file',files[i]);
                    d.append('type',this.uploadConfigs.file_type);
                    d.append('folder_id',this.currentFolder.id);
                    me.isLoading = true;
                    $.ajax({
                        url:bookingCore.admin_url+'/module/media/store',
                        data:d,
                        dataType:'json',
                        type:'post',
                        contentType: false,
                        processData: false,
                        success:function (res) {
                            me.isLoading = false;
                            if(res.status)
                            {
                                me.reloadLists();
                            }
                            if(res.status === 0){
                                bookingCoreApp.showError(res);
                            }
                            $(me.$refs.files).val('');
                        },
                        error:function(e){
                            bookingCoreApp.showAjaxError(e);
                            $(me.$refs.files).val('');
                            me.isLoading = false;
                        }
                    })
                }
            },
            initUploader(){

            },
            resetSelected(){
                this.selectedLists = [];
                this.selected = [];
                this.total = 0;
                this.totalPage = 0;
                this.apiFinished = false;
            }
        }
    });
}
