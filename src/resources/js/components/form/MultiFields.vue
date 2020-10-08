<template>
    <div class="cms-multi-fields">
        <ul class="list-unstyled card-stack">
            <li
                v-for="(item, index) of items"
                :key="item.__id"
                class="card shadow-sm"
            >
                <div class="card-body p-3">
                    <div
                        @click.prevent="onClickRemove(index)"
                        class="btn-remove btn btn-circle-sm btn-danger"
                    >
                        <i class="fas fa-trash fa-sm"></i>
                    </div>

                    <div ref="items">
                        <slot />
                    </div>
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
import VNode from 'vue';

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
    created () {
        // TODO: Slots is not being updated with all the new ones that are
        // created with the for loop. It would be best if we can access so
        // called VNodes. Maybe take a look a jsx manually rendering by
        // extracting what PHP is passing to the default slot.
        // this.$refs.items.forEach((r, i) => this.setInputNames(r, i));
    },
    methods: {
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
        setInputNames(target, itemIndex) {
            if (target instanceof HTMLCollection) {
                for (let t of target) {
                    this.setInputNames(t, itemIndex);
                }

                return;
            }

            if (target.__vue__) {
                target.__vue__.name = target
                    .__vue__
                    .name
                    .replace(/\[\d*\]/, `[${itemIndex}]`);

                return;
            }

            const name = target.getAttribute('name');
            
            // TODO: also alter id.

            if (name) {
                target.setAttribute(
                    'name',
                    name.replace(/\[\d*\]/, `[${itemIndex}]`),
                );
            }

            if (target.children) {
                this.setInputNames(target.children, itemIndex);
            }
        },
    },
    watch: {
        items () {
            this.$nextTick(() => {
                this.$refs.items.forEach((s, i) => this.setInputNames(s, i));
            });
        },
    },




    //     constructInputValues (values, parentKey) {
    //         if (typeof(values) !== 'object') {
    //             return [values, parentKey];
    //         }

    //         let constructed = {};

    //         for (let key in values) {
    //             let result = this.constructInputValues(
    //                 values[key],
    //                 `${parentKey}[${key}]`
    //             );

    //             if (Array.isArray(result)) {
    //                 constructed[result[1]] = result[0];
    //             } else {
    //                 constructed = Object.assign(constructed, result);
    //             }
    //         }

    //         return constructed;
    //     },
    //     extractParentName(name) {
    //         return name
    //             .replace(new RegExp(`${this.name}\\[\\d*\\]`), '')
    //             .replace(/\[/, '')
    //             .replace(/\]/, '');
    //     },
    //     generateId () {
    //         return Date.now() + '-' + Math.floor(Math.random() * 10000);
    //     },
    //     onClickAdd () {
    //         this.items.push({
    //             __id: this.generateId(),
    //         });
    //     },
    //     onClickRemove (index) {
    //         this.items.splice(index, 1);
    //     },
    //     setInputNamesOld () {
    //         const items = this.$refs.items || [];

    //         items.forEach((item, i) => {
    //             const inputs = item.querySelectorAll('input');

    //             // TODO: Would be nice to check if there are any vue component
    //             // if which the `name` value can be changed instead of having a
    //             // `realName` method to retrieve it. Check `FieldInput` for
    //             // example. Those components should just be able to live
    //             // happily without thinking about this component.

    //             const indexes = [i];

    //             inputs.forEach((input) => {
    //                 let name = input.getAttribute('name');

    //                 const matches = name.match(/\[\d*\]/g);

    //                 indexes.forEach((index, j) => {
    //                     // `replace` only replaces first match.
    //                     name = name.replace(matches[j], `[${index}]`);
    //                 });

    //                 input.setAttribute('name', name);
    //             });
    //         });
    //     },
    //     setInputValues () {
    //         const constructed = this.constructInputValues(this.items, this.name);

    //         for (let key in constructed) {
    //             const input = this.$el.querySelector(`input[name="${key}"]`);

    //             if (input) {
    //                 input.setAttribute('value', constructed[key]);
    //             }
    //         }

    //         // WIP: setting vue component values
    //         console.log(this.name, this.items);

    //         this.$children.forEach((c) => {
    //             console.log(c.name);

    //             const name = this.extractParentName(c.name);
    //         });
    //     },
    // },
    // watch: {
    //     items () {
    //         this.$nextTick(() => {
    //             this.setInputNames();
    //         });
    //     },
    // },
};
</script>
