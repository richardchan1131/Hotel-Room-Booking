<div id="cdn-browser-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div id="cdn-browser" class="cdn-browser d-flex flex-column" v-cloak :class="{is_loading:isLoading}">
                <div class="files-nav flex-shrink-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-left d-flex align-items-center">
                            <div class="filter-item">
                                <input type="text" placeholder="{{__("Search file name....")}}" class="form-control" v-model="filter.s" @keyup.enter="filter.page = 1;reloadLists()">
                            </div>
                            <div class="filter-item">
                                <button class="btn btn-default" @click="reloadAll()">
                                    <i class="fa fa-search"></i> {{__("Search")}}</button>
                            </div>
                            <div class="filter-item">
                                <small><i>{{__("Total")}}: @{{total}} {{__("files")}}</i></small>
                            </div>
                        </div>
                        <div class="div">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" @click="setViewType('grid')" class="btn" :class="viewType == 'grid' ? 'btn-secondary' : 'btn-outline-secondary'"><i class="fa fa-th"></i></button>
                                <button type="button" @click="setViewType('list')" class="btn" :class="viewType != 'grid' ? 'btn-secondary' : 'btn-outline-secondary'"><i class="fa fa-bars"></i></button>
                            </div>
                        </div>
                        <div class="col-right">
                            <i class="fa-spin fa fa-spinner icon-loading active" v-show="isLoading"></i>
                            <button class="btn btn-primary mr-2" @click="addFolder">
                                <span><i class="fa fa-folder"></i> {{__("Add Folder")}}</span>
                            </button>
                            <button class="btn btn-success btn-pick-files">
                                <span><i class="fa fa-upload"></i> {{__("Upload")}}</span>
                                <input multiple :accept="accept_type" type="file" name="files[]" ref="files">
                            </button>
                        </div>
                    </div>
                </div>
                <div class="upload-new" v-show="showUploader" display="none">
                    <input type="file" name="filepond[]" class="my-pond">
                </div>
                <div class="files-list">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a @click="toFolderRoot" href="#">{{__("Home")}}</a></li>
                            <li v-for="(item,index) in breadcrumbs"  class="breadcrumb-item active" aria-current="page"><a @click.prevent="showFolder(item,index)" href="#">@{{ item.name }}</a></li>
                        </ol>
                    </nav>
                    <div class="border-top border-left mb-3 px-3" v-if="viewType == 'list'">
                        <div class="row font-weight-bold " style="font-size: 16px">
                            <div class="col-sm-6 py-2 border-bottom border-right">{{__("Name")}}</div>
                            <div class="col-sm-2 py-2 border-bottom border-right">{{__("Type")}}</div>
                            <div class="col-sm-2 py-2 border-bottom border-right">{{__("Created At")}}</div>
                            <div class="col-sm-2 py-2 border-bottom border-right">{{__("Size")}}</div>
                        </div>
                        <folder-item @deleted="deletedFolder" @toggle-edit="toggleEditFolder" @dblclick="showFolder(folder)" @update="updateFolder" :view-type="viewType" v-for="(folder,index) in folders" :index="index" :key="'folder-'+index" :folder="folder"></folder-item>
                        <file-item v-for="(file,index) in files" :key="index" :view-type="viewType" :selected="selected" :file="file" v-on:select-file="selectFile"></file-item>
                    </div>
                    <div class="files-wraps " v-if="viewType == 'grid'" :class="'view-'+viewType">
                        <folder-item @deleted="deletedFolder" @toggle-edit="toggleEditFolder" @dblclick="showFolder(folder)" @update="updateFolder" v-for="(folder,index) in folders" :index="index" :key="'folder-'+index" :folder="folder"></folder-item>
                        <file-item v-for="(file,index) in files" :key="index" :view-type="viewType" :selected="selected" :file="file" v-on:select-file="selectFile"></file-item>
                    </div>
                    <p class="no-files-text text-center" v-show="!total && apiFinished" style="display: none">{{__("No file found")}}</p>
                    <div class="text-center" v-if="totalPage > 1">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item" :class="{disabled:filter.page <= 1}">
                                    <a class="page-link" v-if="filter.page <=1">{{__("Previous")}}</a>
                                    <a class="page-link" href="#" v-if="filter.page > 1" v-on:click="changePage(filter.page-1,$event)">{{__("Previous")}}</a>
                                </li>
                                <li class="page-item" v-if="p >= (filter.page-3) && p <= (filter.page+3)" :class="{active: p == filter.page}" v-for="p in totalPage" @click="changePage(p,$event)">
                                    <a class="page-link" href="#">@{{p}}</a></li>
                                <li class="page-item" :class="{disabled:filter.page >= totalPage}">
                                    <a v-if="filter.page >= totalPage" class="page-link">{{__("Next")}}</a>
                                    <a href="#" class="page-link" v-if="filter.page < totalPage" v-on:click="changePage(filter.page+1,$event)">{{__("Next")}}</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="browser-actions d-flex justify-content-between flex-shrink-0" v-if="selected.length">
                    <div class="col-left" v-show="selected.length">
                        <div class="control-remove" v-if="selected && selected.length">
                            <button class="btn btn-danger" @click="removeFiles">{{__("Delete file")}}</button>
                        </div>
                        <div class="control-info" v-if="selected && selected.length">
                            <div class="count-selected">@{{selected.length}} {{__("file selected")}}</div>
                            <div class="clear-selected" @click="selected=[]"><i>{{__("unselect")}}</i></div>
                        </div>
                    </div>
                    <div class="col-right" v-show="selected.length">
                        <button class="btn btn-primary" :class="{disabled:!selected.length}" @click="sendFiles">{{__("Use file")}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/x-template" id="file-item-template">
    <div :class="viewType == 'grid'  ? 'file-item' : 'file-list-item'" >
        <div class="row hover:bg-f5f5f5 cursor-pointer" v-if="viewType == 'list'" @click="selectFile(file)" :class="{'active':selected.indexOf(file.id) !== -1}">
            <div class="col-sm-6 py-1 border-right border-bottom">
                <span v-html="getFileThumb(file)" class="mr-2 item-preview"></span> @{{ file.file_name }}</div>
            <div class="col-sm-2 py-1  border-right border-bottom">@{{file.file_extension}}</div>
            <div class="col-sm-2 py-1  border-right border-bottom">@{{file.created_at}}</div>
            <div class="col-sm-1 py-1 border-bottom">@{{humanFileSize(file.file_size)}}</div>
            <div class="col-sm-1 py-1  border-right border-bottom d-flex justify-content-end">
                <a :href="file.full_size" target="_blank" title="{{__("View file")}}"><i class=" fa fa-eye"></i></a>
            </div>
        </div>
        <div v-if="viewType == 'grid'" class="inner" :class="{active:selected.indexOf(file.id) !== -1 }" @click="selectFile(file)" :title="file.file_name">
            <div class="file-thumb" v-if="viewType=='grid'" v-html="getFileThumb(file)">
                </div>
                <div class="file-name">@{{file.file_name}}</div>
                <span class="file-checked-status" v-show="selected.indexOf(file.id) !== -1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M186.301 339.893L96 249.461l-32 30.507L186.301 402 448 140.506 416 110z"/></svg>
            </span>
        </div>
    </div>
</script>
<script type="text/x-template" id="folder-item-template">
    <div :class="viewType == 'grid'  ? 'file-item folder-item' : 'folder-item'" @dblclick="$emit('dblclick',folder,index)">
        <div class="row hover:bg-f5f5f5 cursor-pointer" v-if="viewType == 'list'">
            <div class="col-sm-6 py-1 border-right border-bottom">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-grow-1 align-items-center">
                        <div>
                            <img src="/icon/folder.png" width="20px" height="auto" class="mr-2 flex-shrink-0" alt="">
                        </div>
                        <div class="text-center font-weight-medium" v-if="!folder.onEdit">@{{folder.name}}</div>
                        <div class="" v-if="folder.onEdit">
                            <input ref="input" type="text" @blur="saveName" class="form-control" v-model="folder_name" >
                        </div>
                    </div>
                    <div>
                        <a href="#" class="btn-edit btn-sm position-absolute" @click.prevent="openEdit"><i class="fa fa-edit"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 py-1 border-right border-bottom">{{__("Folder")}}</div>
            <div class="col-sm-2 py-1 border-right border-bottom">@{{ folder.created_at }}</div>
            <div class="col-sm-2 py-1 border-right border-bottom d-flex justify-content-end">
                <a href="#" class="btn-sm text-danger" title="{{__("Delete this folder")}}" @click.prevent="deleteFolder"><i class="fa fa-trash"></i></a>
            </div>
        </div>
        <div v-if="viewType == 'grid'" class="inner d-flex flex-column  position-relative">
            <div class="file-thumb flex-grow-1 d-flex align-items-center justify-content-center" style="background: #7b7d7e">
                <i class="fa fa-folder-o" style="font-size: 90px;color:white"></i>
            </div>
            <div class="text-center font-weight-medium p-2" v-if="!folder.onEdit">@{{folder.name}}</div>
            <div class="" v-if="folder.onEdit">
                <input ref="input" type="text" @blur="saveName" class="form-control" v-model="folder_name" >
            </div>
            <a href="#" class="btn-edit btn btn-sm btn-warning position-absolute top-0 right-0 m-2" @click.prevent="openEdit"><i class="fa fa-edit"></i></a>
        </div>
    </div>
</script>
