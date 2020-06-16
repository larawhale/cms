<template>
    <div class="cms-multi-fields">
        <ul class="list-unstyled card-stack">
            <li
                v-for="(item, index) of items"
                :key="item.id"
                class="card shadow-sm"
            >
                <div
                    class="card-body p-3"
                    ref="items"
                >
                    <div
                        @click.prevent="onClickRemove(index)"
                        class="btn-remove btn btn-circle-sm btn-danger"
                    >
                        <i class="fas fa-trash fa-sm"></i>
                    </div>

                    <slot />
                </div>
            </li>
        </ul>

        <div
            @click.prevent="onClickAdd"
            class="btn btn-sm btn-success"
        >
            Add
        </div>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            type: Array,
            default: () => [{}],
        },
    },
    data () {
        return {
            items: this.value.slice(0).map((item) => {
                item.id = this.generateId();

                return item;
            }),
        };
    },
    mounted () {
        this.setInputNames();
    },
    methods: {
        generateId () {
            return Date.now() + '-' + Math.floor(Math.random() * 100);
        },
        onClickAdd () {
            this.items.push({
                id: this.generateId(),
            });
        },
        onClickRemove (index) {
            this.items.splice(index, 1);
        },
        setInputNames () {
            const items = this.$refs.items || [];

            items.forEach((item, i) => {
                const inputs = item.querySelectorAll('input');

                const indexes = [i];

                inputs.forEach((input) => {
                    let name = input.getAttribute('name');

                    const matches = name.match(/\[\d*\]/g);

                    indexes.forEach((index, j) => {
                        // `replace` only replaces first match.
                        name = name.replace(matches[j], `[${index}]`);
                    });

                    input.setAttribute('name', name);
                });
            });
        },
    },
    watch: {
        items () {
            this.$nextTick(() => {
                this.setInputNames();
            });
        },
    },
};
</script>
