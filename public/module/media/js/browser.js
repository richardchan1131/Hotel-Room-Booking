(function ($) {
    window.uploaderModal = new Vue({
        el: '#cdn-browser',
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
            multiple:false,
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
            accept_type:bookingCore.media.groups.default.mime.join(','),
            modal:null,
            isBs4:true
        },
        mounted(){
            let me = this;
            if (typeof $.fn.modal === 'function') {
                $('#cdn-browser-modal').modal({show:false})
            }else{
                this.modal = new bootstrap.Modal('#cdn-browser-modal');
                this.isBs4 = false;
            }
            this.modalEl = $('#cdn-browser-modal').on('show.bs.modal',function () {
                me.reloadLists();
                me.reloadFolder();
            });

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
                if(this.isBs4){
                    this.modalEl.modal('show');
                }else{
                    this.modal.show();
                }
            },
            hide(){
                if(this.isBs4){
                    this.modalEl.modal('hide');
                }else{
                    this.modal.hide();
                }
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

    Vue.component('file-item', {
        template:'#file-item-template',
        data: function () {
            return {
                count: 0
            }
        },
        props:['file',"selected","viewType"],
        methods:{
            selectFile(file){
                this.$emit('select-file',file);
            },
            fileClass(file){
                var s = [];
                s.push(file.file_type);

                if(file.file_type.substr(0,5)=='image'){
                    s.push('is-image');
                }else{
                    s.push('not-image');
                }
                return s;
            },
            getFileThumb(file){
                if(file.file_type.substr(0,5)=='image'){
                    return '<img src="'+file.thumb_size+'">';
                }
                if(file.file_type.substr(0,5)=='video'){
                    return '<img src="/icon/007-video-file.png">';
                }
                if(file.file_type.indexOf('x-zip-compressed')!== -1 || file.file_type.indexOf('/zip')!== -1){
                    return '<img src="/icon/005-zip-2.png">';
                }
                if(file.file_type.indexOf('/pdf')!== -1 ){
                    return '<img src="/icon/002-pdf-file-format-symbol.png">';
                }

                if(file.file_type.indexOf('/msword')!== -1 || file.file_type.indexOf('wordprocessingml')!== -1){
                    return '<img src="/icon/010-word.png">';
                }
                if(file.file_type.indexOf('spreadsheetml')!== -1  || file.file_type.indexOf('excel')!== -1){
                    return '<img src="/icon/011-excel-file.png">';
                }
                if(file.file_type.indexOf('presentation')!== -1 ){
                    return '<img src="/icon/powerpoint.png">';
                }
                if(file.file_type.indexOf('audio/')!== -1 ){
                    return '<img src="/icon/006-audio-file.png">';
                }

                return '<img src="/icon/008-file.png">';

            },
            humanFileSize:function (bytes, si=false, dp=1) {
                if(typeof bytes == 'undefined' || !bytes) return '';
                const thresh = si ? 1000 : 1024;

                if (Math.abs(bytes) < thresh) {
                    return bytes + ' B';
                }

                const units = si
                    ? ['kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
                    : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
                let u = -1;
                const r = 10**dp;

                do {
                    bytes /= thresh;
                    ++u;
                } while (Math.round(Math.abs(bytes) * r) / r >= thresh && u < units.length - 1);


                return bytes.toFixed(dp) + ' ' + units[u];
            }
        }
    })

    Vue.component('folder-item', {
        template:'#folder-item-template',
        data: function () {
            return {
                folder_name: '',
                saving:false
            }
        },
        props:{
            folder:{
                type:Object,
                default:{
                    name:'',
                    id:'',
                    onEdit:false
                }
            },
            index:{
                type:Number,
                default:0
            },
            viewType:{
                type:String,
                default:'grid'
            }
        },
        watch:{
            folder:function (val){
                console.log(val);
                var me = this;
                if(val.onEdit){
                    this.$nextTick(function (){
                        if(me.$refs.input){
                            me.$refs.input.select();
                        }
                    })
                }
            }
        },
        methods:{
            deleteFolder:function (){
                const c = confirm('Do you want to delete folder and all files inside it?');
                if(!c) return;
                if(this.saving) return;

                var me = this;
                this.saving = true;
                $.ajax({
                    url:bookingCore.url+'/media/folder/delete',
                    data:{
                        id:this.folder.id,
                    },
                    type:'post',
                    dataType:'json',
                    success:function (json){
                        me.saving = false;
                        if(json.status){
                            me.$emit('deleted',me.index);
                            bookingCoreApp.showAjaxMessage(json)

                        }
                    },
                    error:function (e){
                        me.saving = false;
                        bookingCoreApp.showAjaxError(e)
                    }
                })
            },
            openEdit:function (){
                this.$emit('toggle-edit',this.index,true);
            },
            saveName:function(){
                if(this.saving) return;

                var me = this;
                this.saving = true;
                $.ajax({
                    url:bookingCore.url+'/media/folder/store',
                    data:{
                        id:this.folder.id,
                        name:this.folder_name,
                        parent_id:this.folder.parent_id
                    },
                    type:'post',
                    dataType:'json',
                    success:function (json){
                        me.saving = false;
                        if(json.status){
                            me.$emit('update',me.index,json.data);
                        }
                    },
                    error:function (e){
                        me.saving = false;
                        bookingCoreApp.showAjaxError(e)
                    }
                })
            },
        },
        mounted() {
            var me = this;
            this.folder_name = this.folder.name;
            if(this.folder.onEdit && this.$refs.input){
                this.$refs.input.select();
            }
        }
    })
})(jQuery);
