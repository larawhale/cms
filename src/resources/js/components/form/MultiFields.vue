<template>
    <div>
        <ul>
            <li v-for="(item, index) of items" :key="item.id">
                <div ref="items">
                    <a
                        @click.prevent="onClickRemove(index)"
                        class="btn btn-sm btn-danger"
                    >
                        x
                    </a>

                    <slot />
                </div>
            </li>
        </ul>

        <a
            @click.prevent="onClickAdd"
            class="btn btn-sm btn-success"
        >
            Add
        </a>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            type: Array,
            default: () => [],
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
