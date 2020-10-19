<template>
    <div class="input-group">
        <div
            v-if="file"
            class="input-group-prepend"
            @click="onClickRemove"
        >
            <div class="btn btn-danger btn-remove">
                <i class="fas fa-trash" />
            </div>
        </div>

        <div
            class="form-control"
            @click="onClickFile"
        >
            {{ file || placeholder }}
        </div>

        <input
            class="d-none"
            :id="id"
            :name="name"
            ref="input"
            type="file"
            @change="onChangeInput"
        >

        <input
            v-if="remove"
            :name="name"
            type="hidden"
            value="remove"
        >

        <div
            class="input-group-append"
            @click="onClickFile"
        >
            <div class="btn btn-outline-secondary">
                <i class="fas fa-folder-open" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        id: {
            type: String,
            default: undefined,
        },
        name: {
            type: String,
            default: undefined,
        },
        placeholder: {
            type: String,
            default: undefined,
        },
        value: {
            type: String,
            default: undefined,
        },
    },
    data () {
        return {
            file: this.value,
            remove: false,
        };
    },
    methods: {
        onClickRemove(e) {
            e.stopPropagation();

            this.remove = true;

            this.file = undefined;

            this.$refs.input.value = '';

            this.$emit('remove', this.file);
        },
        onClickFile(e) {
            this.$refs.input.click();
        },
        onChangeInput(e) {
            const files = this.$refs.input.files;

            if (files && files.length > 0) {
                this.file = files[0].name;

                this.$emit('input', this.file);
            }
        },
    },
};
</script>
