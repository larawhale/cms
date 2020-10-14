<template>
    <div>
        <template v-for="(file, i) of computedFiles">
            <keep-alive :key="file + i">
                <cms-file-input
                    v-model="files[i]"
                    class="mb-3"
                    :class="{'d-none': remove.includes(i)}"
                    :id="i === computedFiles.length - 1 ? id : 'toeter'"
                    :name="`${name}[${i}]`"
                    :placeholder="placeholder"
                    @remove="remove.push(i)"
                ></cms-file-input>
            </keep-alive>
        </template>
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
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {
            files: [...this.value],
            remove: [],
        };
    },
    computed: {
        computedFiles() {
            return [...this.files, ''];
        },
    },
    methods: {
        onNewInput(file) {
            this.files.push(file);
        },
    },
};
</script>
