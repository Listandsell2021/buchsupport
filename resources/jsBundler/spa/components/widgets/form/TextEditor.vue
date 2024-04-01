<template>
<div>
    <ClientOnly>
        <ckeditor :config="editorConfig" :editor="editor" v-model="editorData"></ckeditor>
    </ClientOnly>
</div>
</template>

<script>
import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
    name: 'composeView',
    components: {
        ckeditor: CKEditor.component
    },
    data() {
        return {
            editor: ClassicEditor,
            editorData: '',
            editorConfig: {
                config: {
                    height: '300px'
                }
            },
        };
    },

}
</script>
