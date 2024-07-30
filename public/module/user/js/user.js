/*import BookingCoreAdaterPlugin from "../../../../resources/admin/js/ckeditor/uploadAdapter";*/

jQuery(function ($) {
    //Input group image select
    $('.upload-btn-wrapper').each(function () {
        var container = $(this);
        $(document).on('change', '.btn-file :file', function (event) {
            var files = event.target.files;
            var input = $(this);
            var formData = new FormData();
            $.each(files, function (key, value) {
                formData.append('file', value);
            });
            formData.append('type', "image");
            $.ajax({
                url: bookingCore.admin_url+'/module/media/store',
                type: 'POST',
                data: formData,
                enctype: 'multipart/form-data',
                beforeSend: function () {
                    input.trigger("bravo-file-before-update")
                },
                success: function (data) {
                    if (data.status === 1) {
                        input.trigger("bravo-file-update-success", data)
                    } else {
                        input.trigger("bravo-file-update-error", data.message)
                    }
                },
                error: function (xhr) {
                    input.trigger("bravo-file-update-error")
                },
                complete: function () {
                    input.trigger("bravo-file-update-complete")
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
        container.find('.btn-file :file').on('bravo-file-update-success', function (event, data) {
            console.log(data);
            container.find("input[type=hidden]").attr('value', data.data.id);
            container.find(".image-demo").attr('src', data.data.sizes.default);
            container.find(".text-view").attr('value', data.data.sizes.default);
        });
        container.find('.btn-file :file').on('bravo-file-before-update', function () {
            container.find(".text-view").attr('value', container.find(".text-view").data("loading"));
        });
        container.find('.btn-file :file').on('bravo-file-update-error', function (event, message) {
            if (message.length > 0) {
                container.find(".text-view").attr('value', message);
            } else {
                container.find(".text-view").attr('value', container.find(".text-view").data("error"));
            }
        });
    });
    $(".form-group-item").each(function () {
        let container = $(this);
        $(this).on('click', '.btn-remove-item', function () {
            $(this).closest(".item").remove();
        });
        $(this).on('press', 'input,select', function () {
            let value = $(this).val();
            $(this).attr("value", value);
        });
    });
    $(".form-group-item .btn-add-item").click(function () {
        let number = $(this).closest(".form-group-item").find(".g-items .item:last-child").data("number");
        if (number === undefined) number = 0;
        else number++;
        let extra_html = $(this).closest(".form-group-item").find(".g-more").html();
        extra_html = extra_html.replace(/__name__=/gi, "name=");
        extra_html = extra_html.replace(/__number__/gi, number);
        $(this).closest(".form-group-item").find(".g-items").append(extra_html);
    });

    $(document).on('click', '.dungdt-upload-box-normal .edit-img, .dungdt-upload-multiple .edit-img, .show_avatar .edit-img', function (e) {
        e.preventDefault();
        let $this = $(this);
        let image_path = $this.attr('data-file');
        let edit_type = ($this.hasClass('edit-multiple')) ? 'multiple' : 'single';
        let p = (edit_type === 'multiple') ? $this.closest('.dungdt-upload-multiple') : $this.closest('.dungdt-upload-box');
        let image_id = (edit_type === 'multiple') ? $this.attr('data-id') : p.attr('data-val');
        let config = {
            language: image_editer.language,
            translations: image_editer.translations,
            reduceBeforeEdit : {
                mode: 'manual',
                widthLimit: 2500,
                heightLimit: 2500
            }
        };

        let callback = {
            onOpen: () => {

            },
            onBeforeComplete: (props) => {
                return false;
            },
            onComplete: function (url){
                var canvas = url.canvas.toDataURL('image/jpeg');

                if (edit_type === 'multiple'){
                    $this.closest('.image-item').find('.image-preview').attr('src',canvas);
                } else {
                    p.find('.attach-demo').html('<img src="' + canvas + '" alt="image-responsive" style="max-width: 150px">');
                }

                $.ajax({
                    url: bookingCore.url + '/media/edit_image',
                    method: 'POST',
                    dataType: 'JSON',
                    data:{
                        image: canvas,
                        image_id: image_id,
                    },
                    success:function (result) {
                        console.log(result);
                    }
                });
            }
        };
        let ImageEditor = new FilerobotImageEditor(config, callback);
        ImageEditor.open(image_path);
    });

    $(document).on('click','.dungdt-upload-box-normal .btn-field-upload,.dungdt-upload-box-normal .attach-demo',function () {
        let p = $(this).closest('.dungdt-upload-box');
        uploaderModal.show({
            multiple: false,
            file_type: 'image',
            onSelect: function (files) {
                let path = (files[0].edit_path !== undefined) ? files[0].edit_path : files[0].max_large_size;
                p.addClass('active');
                p.find('.attach-demo').html('<img src="' + files[0].thumb_size + '"/>');
                p.attr('data-val',files[0].id);
                p.find('input').val(files[0].id);
                p.find('.edit-img').attr('data-file', path);
            },
        });

    });
    $('.dungdt-upload-box-normal .delete').click(function (e) {
        e.preventDefault();
        let p = $(this).closest('.dungdt-upload-box');
        p.find("input").attr('value','')
        p.removeClass("active");
    });
    $('.dungdt-upload-multiple').find('.btn-field-upload').click(function () {
        let p = $(this).closest('.dungdt-upload-multiple');
        uploaderModal.show({
            multiple: true,
            file_type: 'image',
            onSelect: function (files) {
                if (typeof files != 'undefined' && files.length) {
                    var ids = [];
                    var html = '';
                    p.addClass('active');
                    for (var i = 0; i < files.length; i++) {
                        let path = (files[i].edit_path !== undefined) ? files[i].edit_path : files[i].max_large_size;
                        ids.push(files[i].id);
                        html += '<div class="image-item">' +
                            '<div class="inner">';
                        html += '<a class="edit-img btn btn-sm btn-primary edit-multiple" data-id="'+files[i].id+'" data-file="'+path+'"><i class="fa fa-edit"></i></a>'
                        html += '<span class="delete btn btn-sm btn-danger"><i class="fa fa-trash"></i></span><div class="img-preview"><img class="image-responsive image-preview w-100" src="' + files[i].thumb_size + '"/></div>' +
                            '</div>' +
                            '</div>'
                    }
                    p.find('.attach-demo').append(html);
                    var old = p.find('input').val().split(',');
                    p.find('input').val(ids.concat(old).join(','));
                }
            },
        });
    });


    $('.dungdt-upload-multiple').on('click', '.image-item .delete', function () {
        var i = $(this).closest('.image-item').index();
        let p = $(this).closest('.dungdt-upload-multiple');
        var ids = p.find('input').val().split(',');
        ids.splice(i, 1);
        p.find('input').val(ids.join(','));
        $(this).closest('.image-item').remove();
    });

    $(".bravo_user_profile .sidebar-menu .caret").click(function () {
        $(this).closest("li").toggleClass("active_child");
    });

    $(".bravo_user_profile .bravo-list-item .control-action .btn-danger").click(function () {
        var c = confirm($(this).data('confirm'));
        if(!c){
            return false;
        }
    });

    $(".bravo_user_profile .bravo-list-item .control-action .btn-recovery").click(function () {
        var c = confirm($(this).data('confirm'));
        if(!c){
            return false;
        }
    });

    function makeid(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
    // Form Configs
    $('.has-ckeditor').each(function () {
        var els  = $(this);

        var id = $(this).attr('id');

        if(!id){
            id = makeid(10);
            $(this).attr('id',id);
        }
        var h  = els.data('height');
        if(!h && typeof h =='undefined') h = 300;

        // CKEDITOR.replace( id );
        tinymce.init({
            selector:'#'+id,
            plugins: 'preview searchreplace autolink code fullscreen image link media codesample table charmap hr toc advlist lists wordcount imagetools textpattern help pagebreak hr',
            toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | pagebreak codesample code| removeformat',
            image_advtab: true,
            image_caption: true,
            toolbar_drawer: 'sliding',
            relative_urls : false,
            height:h,
            file_picker_callback: function (callback, value, meta) {
                /* Provide file and text for the link dialog */
                if (meta.filetype === 'file') {
                    uploaderModal.show({
                        multiple:false,
                        file_type:'video',
                        onSelect:function (files) {
                            if(files.length)
                                callback(bookingCore.url+'/media/preview/'+files[0].id);
                        },
                    });
                }

                /* Provide image and alt text for the image dialog */
                if (meta.filetype === 'image') {
                    uploaderModal.show({
                        multiple:false,
                        file_type:'image',
                        onSelect:function (files) {
                            if(files.length)
                                callback(files[0].thumb_size);
                        },
                    });
                }

                /* Provide alternative source and posted for the media dialog */
                if (meta.filetype === 'media') {
                    uploaderModal.show({
                        multiple:false,
                        file_type:'video',
                        onSelect:function (files) {
                            if(files.length)
                                callback(bookingCore.url+'/media/preview/'+files[0].id);
                        },
                    });
                }
            },
        });

    });


    $(".bravo_user_profile .sidebar-menu .active_child").each(function () {
        $(this).closest('.has-children').addClass('active_child').addClass('active');
    });

    $('.form-add-service .nav-tabs a').click(function () {
        setTimeout(function () {
            window.dispatchEvent(new Event('resize'));
        },200)
    });

    $('.btn-upload-private-file').change(function () {
        var me = $(this);
        var p = $(this).closest('.btn-upload-private-wrap');
        var lists = p.find('.private-file-lists');

        me.isLoading = true;
        for(var i = 0 ;i < me.get(0).files.length ; i++) {
            var d = new FormData();
            d.append('file',me.get(0).files[i]);
            $.ajax({
                url: bookingCore.url + '/media/private/store',
                data: d,
                dataType: 'json',
                type: 'post',
                contentType: false,
                processData: false,
                success: function (res) {
                    me.val('');
                    if (res.status === 0) {
                        bookingCoreApp.showError(res);
                    }
                    if (res.data) {
                        var div = $('<div/>');
                        var input = $("<input/>");
                        input.attr('type', 'hidden');
                        input.attr('name', me.data('name'));
                        input.val(JSON.stringify(res.data));

                        div.append(input);
                        div.append("<a target='_blank' href='" + res.data.download + "'> " + res.data.name + '.' + res.data.file_extension + " <i class=\"fa fa-download\"></i> </a>");

                        if (me.data('multiple')) {
                            lists.append(div);
                        } else {
                            lists.html(div);
                        }
                    }
                },
                error: function (e) {
                    bookingCoreApp.showAjaxError(e);
                    me.val('');
                }
            })
        }
    })

    $('.dungdt-select2-field').each(function () {
        var configs = $(this).data('options');
        $(this).select2(configs);
    })


    $('.tag-input').keypress(function (e) {
        // console.log(e);

        if(e.keyCode == 13){
            var val = $(this).val();

            if(val){
                var html = '<span class="tag_item">' + val +
                    '       <span data-role="remove"></span>\n' +
                    '                                                    <input type="hidden" name="tag_name[]" value="'+val+'">\n' +
                    '                                                </span>';

                $(this).parent().find('.show_tags').append(html);
                $(this).val('');
            }
            e.preventDefault();
            return false;
        }
    });

    $(document).on('click','[data-role=remove]',function () {
        $(this).closest('.tag_item').remove();
    });

    $('.dungdt-apply-form-btn').click(function (e) {
        var $this = $(this);
        var action = $this.closest('form').find('[name=action]').val();
        var apply_action = function () {
            let ids = '';
            $(".bravo-form-item .check-item").each(function () {
                if($(this).is(":checked")){
                    ids += '<input type="hidden" name="ids[]" value="'+$(this).val()+'">';
                }
            });
            $this.closest('form').append(ids).submit();
        }
        if(action === 'delete' ||  action === 'permanently_delete')
        {
            bookingCoreApp.showConfirm({
                message: i18n.confirm_delete,
                callback: function(result){
                    if(result){
                        apply_action();
                    }
                }
            })
        }else if(action === 'recovery')
        {
            bookingCoreApp.showConfirm({
                message: i18n.confirm_recovery,
                callback: function(result){
                    if(result){
                        apply_action();
                    }
                }
            })
        }else{
            apply_action();
        }
    });

    $('table .check-all').change(function () {
        if($(this).is(':checked'))
        {
            $(this).closest('table').find('tbody .check-item').prop('checked',true);
        }else{
            $(this).closest('table').find('tbody .check-item').prop('checked',false);

        }
    });
});

var vendorPayout = {
    saveAccounts:function (btn) {
        var parent = $(btn).closest('.bravo-form');
        parent.addClass('loading');

        $.ajax({
            url:bookingCore.url+'/vendor/storePayoutAccounts',
            method:"post",
            data:parent.find('input,select,textarea').serialize(),
            dataType:'json',
            success:function (json) {
                parent.removeClass('loading');
                if(json.message){
                    bookingCoreApp.showSuccess(json.message);
                }
                if(json.status){
                    window.setTimeout(function () {
                        window.location.reload();
                    },2000);
                }
            },
            error:function (e) {
                console.log(e);
                parent.removeClass('loading');
                bookingCoreApp.showAjaxError(e);
            }
        })
    },
    sendRequest:function (btn) {
        var parent = $(btn).closest('.modal');
        var form = parent.find('form');
        form.removeClass('was-validated');

        if(form[0].checkValidity() === false){
            form.addClass('was-validated');
            return false;
        }

        parent.addClass('loading');

        $.ajax({
            url:bookingCore.url+'/vendor/createPayoutRequest',
            method:"post",
            data:form.find('input,select,textarea').serialize(),
            dataType:'json',
            success:function (json) {
                parent.removeClass('loading');
                if(json.message){
                    bookingCoreApp.showSuccess(json.message);
                }
                if(json.status){
                    window.setTimeout(function () {
                        window.location.reload();
                    },3000);
                }
            },
            error:function (e) {
                console.log(e);
                parent.removeClass('loading');
                bookingCoreApp.showAjaxError(e);
            }
        })
    }


};
