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

        <div
            class="btn btn-danger btn-sm btn-remove"
            @click="onClickRemove"
        >
            <i class="fas fa-trash" />
        </div>

        <input
            class="d-none"
            :name="name"
            ref="input"
            type="file"
            @change="onChangeInput"
        >

        <input
            v-if="remove"
            class="d-none"
            :name="name"
            type="hidden"
            value="remove"
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
            remove: false,
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
        onClickRemove(e) {
            e.stopPropagation();

            this.remove = true;

            this.image = undefined;

            this.$refs.input.value = '';
        },
        onClickImage(e) {
            this.$refs.input.click();
        },
        onChangeInput() {
            const files = this.$refs.input.files;

            if (files && files.length > 0) {
                this.remove = false;

                const file = files[0];

                const reader = new FileReader();

                reader.onload = (e) => {
                    this.image = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        },
    },
};
</script>
