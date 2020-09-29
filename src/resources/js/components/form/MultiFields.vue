<template>
    <div class="cms-multi-fields">
        <ul class="list-unstyled card-stack">
            <li
                v-for="(item, index) of items"
                :key="item.__id"
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
        name: String,
        value: {
            type: Array,
            default: () => [{}],
        },
    },
    data () {
        return {
            items: this.value.slice(0).map((item) => {
                item.__id = this.generateId();

                return item;
            }),
        };
    },
    mounted () {
        this.setInputNames();

        // this.setInputValues();
    },
    methods: {
        setInputNames() {
            if (! this.items.length) {
                return;
            }

            for (let i in this.items) {
                const item = this.items[i];

                console.log(item);
            }
        },




        constructInputValues (values, parentKey) {
            if (typeof(values) !== 'object') {
                return [values, parentKey];
            }

            let constructed = {};

            for (let key in values) {
                let result = this.constructInputValues(
                    values[key],
                    `${parentKey}[${key}]`
                );

                if (Array.isArray(result)) {
                    constructed[result[1]] = result[0];
                } else {
                    constructed = Object.assign(constructed, result);
                }
            }

            return constructed;
        },
        extractParentName(name) {
            return name
                .replace(new RegExp(`${this.name}\\[\\d*\\]`), '')
                .replace(/\[/, '')
                .replace(/\]/, '');
        },
        generateId () {
            return Date.now() + '-' + Math.floor(Math.random() * 10000);
        },
        onClickAdd () {
            this.items.push({
                __id: this.generateId(),
            });
        },
        onClickRemove (index) {
            this.items.splice(index, 1);
        },
        setInputNamesOld () {
            const items = this.$refs.items || [];

            items.forEach((item, i) => {
                const inputs = item.querySelectorAll('input');

                // TODO: Would be nice to check if there are any vue component
                // if which the `name` value can be changed instead of having a
                // `realName` method to retrieve it. Check `FieldInput` for
                // example. Those components should just be able to live
                // happily without thinking about this component.

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
        setInputValues () {
            const constructed = this.constructInputValues(this.items, this.name);

            for (let key in constructed) {
                const input = this.$el.querySelector(`input[name="${key}"]`);

                if (input) {
                    input.setAttribute('value', constructed[key]);
                }
            }

            // WIP: setting vue component values
            console.log(this.name, this.items);

            this.$children.forEach((c) => {
                console.log(c.name);

                const name = this.extractParentName(c.name);
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
