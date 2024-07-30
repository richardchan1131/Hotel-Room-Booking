import BookingCoreAdaterPlugin from './ckeditor/uploadAdapter'

(function ($) {

    function makeid(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
    window.initEditorFor = function (el){
        var id = el.attr('id');

        if(!id){
            id = makeid(10);
            el.attr('id',id);
        }
        var h  = el.data('height');
        if(!h && typeof h =='undefined') h = 300;

        var remove_script_host = true;
        if(el.attr("data-fullurl") === "true"){
            remove_script_host = false;
        }


        // CKEDITOR.replace( id );
        tinymce.init({
            language: bookingCore.language,
            selector:'#'+id,
            plugins: 'preview searchreplace autolink code fullscreen image link media codesample table charmap hr toc advlist lists wordcount textpattern help pagebreak hr',
            toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | pagebreak codesample code | removeformat',
            image_advtab: false,
            image_caption: false,
            toolbar_drawer: 'sliding',
            relative_urls : false,
            remove_script_host : remove_script_host,
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
                            console.log(files);
                            if(files.length)
                                callback(files[0].full_size);
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
    }

    $('.has-ckeditor').each(function () {
        var els  = $(this);

        initEditorFor(els);

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

    $(document).on('click','.dungdt-upload-box-normal .delete',function (e) {
        e.preventDefault();
        let p = $(this).closest('.dungdt-upload-box');
        p.find("input").attr('value','')
        p.removeClass("active");
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

    $('.dungdt-upload-multiple').on('click','.image-item .delete',function () {
        var i = $(this).closest('.image-item').index();
        let p = $(this).closest('.dungdt-upload-multiple');
        var ids = p.find('input').val().split(',');

        ids.splice(i,1);

        p.find('input').val(ids.join(','));
        $(this).closest('.image-item').remove();

    });

    $('.open-edit-input').click(function () {
        $(this).replaceWith('<input type="text" name="'+$(this).data('name')+'" value="'+$(this).html()+'">');
    })

    $(document).ready(function () {
        $('.dungdt-select2-field').each(function () {
            var configs = $(this).data('options');
            $(this).select2(configs);
        })
    });

    $(".form-group-item").each(function () {
        let container = $(this);
        $(this).on('click','.btn-remove-item',function () {
            $(this).closest(".item").remove();
        });
        $(this).on('press','input,select',function () {
            let value = $(this).val();
            $(this).attr("value",value);
        });
    });
    $(".form-group-item .btn-add-item").click(function () {
        var p = $(this).closest(".form-group-item").find(".g-items");

        let number = $(this).closest(".form-group-item").find(".g-items .item:last-child").data("number");
        if(number === undefined) number = 0;
        else number++;
        let extra_html = $(this).closest(".form-group-item").find(".g-more").html();
        extra_html = extra_html.replace(/__name__=/gi, "name=");
        extra_html = extra_html.replace(/__number__/gi, number);
        const html = $(extra_html);
        p.append(html);

        if(extra_html.indexOf('dungdt-select2-field-lazy') >0 ){
            p.find('.dungdt-select2-field-lazy').each(function () {
                var configs = $(this).data('options');
                $(this).select2(configs);
            });
        }
        if(html.find('.will-has-ckeditor') ){
            html.find('.will-has-ckeditor').each(function (){
                initEditorFor($(this));
            })
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

    $('.dungdt-input-flag-icon').change(function () {
        $(this).closest('.input-group').find('.flag-icon').attr('class','').addClass('flag-icon flag-icon-'+$(this).val());
    });

    $('.dungdt_input_locale').change(function () {

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

    // Form validation
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    jQuery(function ($) {
        $('.has-datepicker').daterangepicker({
            singleDatePicker: true,
            showCalendar: false,
            autoUpdateInput: false, //disable default date
            sameDate: true,
            autoApply           : true,
            disabledPast        : true,
            enableLoading       : true,
            showEventTooltip    : true,
            classNotAvailable   : ['disabled', 'off'],
            disableHightLight: true,
            locale:{
                format:'YYYY/MM/DD'
            }
        }).on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD'));
        });
    })

    $('.bc-dropdown-toggle-filter').click(function () {
        var container = $(this).closest(".dropdown");
        container.find('.dropdown-menu').toggleClass("show");
    });
})(jQuery);
