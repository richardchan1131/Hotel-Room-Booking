<template>
    <div class="bc-spacing-field">
        <div class="d-flex gap-5 text-center">
            <div>
                <input type="text" class="form-control" v-model="value.t">
                <div class="text-center text-gray">Top</div>
            </div>
            <div>
                <input type="text" class="form-control" v-model="value.r">
                <div class="text-center text-gray">Right</div>
            </div>
            <div>
                <input type="text" class="form-control" v-model="value.b">
                <div class="text-center text-gray">Bottom</div>
            </div>
            <div>
                <input type="text" class="form-control" v-model="value.l">
                <div class="text-center text-gray">Left</div>
            </div>
        </div>
    </div>
</template>
<script>
import {abstractField} from 'vue-form-generator';

export default {
    mixins: [abstractField],
    data() {
        return {
            template_i18n: template_i18n,
            defaultValue: {
                t: '',
                r: '',
                b: '',
                l: '',
            },
        };
    },
    computed: {},
    methods: {},
    created() {
        if (typeof this.value !== 'object') {
            this.value = Object.assign({}, this.defaultValue);
        }
    },
};
</script>
