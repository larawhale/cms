<template>
    <div
        class="cms-image-input d-flex align-items-center justify-content-center btn btn-light"
        :class="{'image-selected': !!image}"
        :style="{'width': width, 'height': height}"
        @click="onClickImage"
    >
        <img
            v-if="image"
            :src="image"
            :style="{'max-width': width, 'max-height': height}"
        >

        <i class="fas fa-folder-open select-image-icon" />

        <input
            class="d-none"
            :name="name"
            ref="input"
            type="file"
            @change="onChangeInput"
        >
    </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            default: undefined,
        },
        value: {
            type: String,
            default: undefined,
        },
        width: {
            type: Number|String,
            default: '100px',
        },
        height: {
            type: Number|String,
            default: '100px',
        },
    },
    data () {
        return {
            image: this.value,
        };
    },
    computed: {
        containerStyle() {
            let style = this.image
                ? {}
                : {width: this.width, height: this.height};

            return style;
        },
    },
    methods: {
        onClickImage() {
            this.$refs.input.click();
        },
        onChangeInput() {
            const files = this.$refs.input.files;

            if (files && files.length > 0) {
                const file = files[0];

                const reader = new FileReader();

                reader.onload = (e) => {
                    console.log(e);
                    this.image = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        },
    },
};
</script>
