<template>
    <div
        class="d-flex flex-column h-100 "
    >
        <div class="text-center flex-shrink-0">
            <h5 class="modal-title font-weight-medium text-center px-3 py-1  border-bottom-1 border-bottom-solid border-bottom-gray">{{ currentBlockSetting.name }}</h5>
            <div v-if="tabKeys.length" class="form-tabs d-flex align-items-center justify-content-between">
                <div
                    v-for="key in tabKeys" @click="setTab(key)" :key="key" class="tab-item py-2 px-1 flex-grow-1" :class="{active:currentTab === key}"
                >
                    <i v-if="tabs[key].icon" :class="tabs[key].icon"></i>
                    {{ tabs[key].label }}
                </div>
            </div>
        </div>
        <div
            class="flex-grow-1 overflow-auto p-3"
        >
            <vue-form-generator
                :schema="{fields:schema}" :model="model" :options="options"
            ></vue-form-generator>
        </div>
        <div class="modal-footer flex-shrink-0 p-2">
            <button
                type="button"
                class="btn btn-secondary"
                @click="hideModal"
            >{{ template_i18n.cancel }}
            </button>
            <button
                type="button"
                class="btn btn-primary"
                @click="saveModal"
            >{{ template_i18n.save_block }}
                <i
                    class="fa fa-spin fa-spinner"
                    v-show="onSaving"
                ></i>
            </button>
        </div>
    </div>

</template>
<script>
import VueFormGenerator from "vue-form-generator";

export default {
    data: function () {
        return {
            item: {},
            block: {},
            model: {},
            onEdit: false,
            template_i18n: template_i18n,
            options: {},
            tmp_block: {},
            currentTab: '',
        }
    },
    props: {
        currentModel: {},
        currentBlockSetting: {},
        id: '',
        onSaving:false
    },
    computed: {
        schema() {
            const me = this;
            let settings = this.currentBlockSetting.settings ?? {};
            if (this.currentTab) {
                settings = Object.fromEntries(Object.entries(settings).filter(([_, field]) => {
                    return field.tab === this.currentTab;
                }));
            }
            Object.values(settings).forEach((item) => {
                if (typeof item.conditions === 'undefined') return true;

                item.visible = function() {
                    var status = true;
                    _.forEach(item.conditions, function(value, key) {
                        if (me.model[key] != value && !value.includes(me.model[key])) {
                            status = false;
                        }
                    });
                    return status;
                };
            });
            return settings;
        },
        tabs() {
            return this.currentBlockSetting.setting_tabs || {};
        },
        tabKeys() {
            const tabs = this.tabs;
            return Object.keys(this.tabs).sort((a) => {
                return (tabs[a]?.order || 0) - (tabs[a]?.order || 0);
            });
        },
    },
    watch: {
        currentModel(val) {
            this.model = Object.assign({}, val ?? {});
        },
        tabKeys(val) {
            this.currentTab = val[0];
        }
    },
    components: {
        "vue-form-generator": VueFormGenerator.component,
    },
    methods: {
        saveModal() {
            console.log(this.model);
            this.$emit('save', Object.assign({}, this.model))
        },
        hideModal() {
            this.$emit('cancel')
        },
        setTab(tab) {
            this.currentTab = tab;
        }
    },
    mounted() {
        this.model = Object.assign({}, this.currentModel ?? {});
        this.$nextTick(() => {

            if (!this.currentTab && this.tabKeys.length) {
                this.currentTab = this.tabKeys[0];
            }
        });
    }
}
</script>
