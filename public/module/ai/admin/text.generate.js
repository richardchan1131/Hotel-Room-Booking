const AiTextGenerator = new Vue({
    el: '#ai_text_generate',
    data: {
        message: '',
        newMessage: '',
        apiStatus: {
            type: false,
            content: '',
        },
        loading: false,
        fieldId: '',
        fieldType: '',
        useContentCb: null,
    },
    methods: {
        show(fieldId, fieldType, cb) {
            this.fieldType = fieldType;
            this.fieldId = fieldId;
            this.useContentCb = cb;
            $('#ai_text_generate').modal('show');
        },
        hide() {
            $('#ai_text_generate').modal('hide');
        },
        submit(e) {
            e.preventDefault();
            if (this.loading) return;

            this.loading = true;
            this.newMessage = '';
            this.apiStatus.content = '';

            var me = this;

            $.ajax({
                url: ai_routes.text.url,
                dataType: 'json',
                method: 'post',
                data: {
                    message: this.message,
                    type: this.fieldType,
                },
                success(res) {
                    if (res.content) {
                        me.newMessage = res.content;
                    }
                    me.loading = false;
                },
                error(e) {
                    var json = e.responseJSON;
                    const message = json?.message || e.responseText;
                    me.apiStatus = {
                        type: false,
                        content: message,
                    };
                    me.loading = false;
                },
            });
        },
        useContent() {
            if (!this.newMessage) return;
            if (this.useContentCb) {
                this.useContentCb(this.newMessage);
            }
            this.hide();
        },
    },
});
$(document).ready(function() {
    $('.magic-field').each(function() {
        const group = $(this);
        const label = group.find('> .control-label');
        const fieldId = group.data('id');
        const fieldType = group.data('type');
        const isEditor = group.data('editor');
        const button = $(
            '<a href=\'#\' class=\'ml-2 badge badge-warning\'>Magic Text <i class="fa fa-magic"></i></a>');
        label.append(button);

        button.on('click', function(e) {
            e.preventDefault();
            AiTextGenerator.show(fieldId, fieldType, (newContent) => {
                if (isEditor) {
                    var editor = tinymce.get(fieldId); // use your own editor id here - equals the id of your textarea
                    if (editor) {
                        editor.setContent(newContent);
                    }
                } else {
                    $('[name=' + fieldId + ']').val(newContent);
                }
            });
        });
    });
});
