export default {
    tinyMce: {
        key:  import.meta.env.VITE_TINYMCE_API_KEY,
        config: {
            menubar: false,
            toolbar: "undo redo | blocks fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | visualblocks | code | preview",
            plugins: "table | link | visualblocks | code | lists | emoticons | image | preview"
        }
    }
}