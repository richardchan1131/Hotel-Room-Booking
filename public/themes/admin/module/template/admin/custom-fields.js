import fieldEditor from "./fields/field-editor.vue";
import fieldSelect2 from "./fields/field-select2.vue";
import fieldListItem from "./fields/field-listItem.vue";
import fieldUpload from "./fields/field-upload.vue";
import fieldRadio from "./fields/field-radio-images.vue";
import fieldSpacing from './fields/field-spacing.vue';

import Vue from 'vue'

Vue.component("fieldEditor", fieldEditor);
Vue.component("fieldSelect2", fieldSelect2);
Vue.component("fieldListItem", fieldListItem);
Vue.component("fieldUploader", fieldUpload);
Vue.component("fieldRadioImages", fieldRadio);
Vue.component('fieldSpacing', fieldSpacing);

