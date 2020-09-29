<template>
    <div class="cms-multi-select">
        <div class="dropdown">
            <div
                class="dropdown-toggle form-control"
                ref="dropdownToggle"
                @click="onClickToggle"
            >
                {{ selectionText }}
            </div>

            <div
                class="dropdown-menu w-100"
                :class="{ show }"
                ref="dropdownMenu"
            >
                <template v-if="options.length">
                    <a
                        v-for="option of options"
                        class="dropdown-item"
                        :class="{ active: selection.includes(option) }"
                        href="#"
                        @click.prevent="onClickOption(option)"
                    >
                        {{ list[option] }}

                        <input
                            v-if="selection.includes(option)"
                            type="hidden"
                            :name="`${realName()}[]`"
                            :value="option"
                        >
                    </a>
                </template>

                <div
                    v-else
                    class="dropdown-item disabled"
                >
                    No options available
                </div>
            </div>
        </div>

        <!--
            This component does not work without the following input when
            included in the `MultiFields` component. The `MutliFields`
            component changes names according to the item index.
        -->
        <input
            disabled
            :name="name"
            ref="nameInput"
            type="hidden"
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
            type: Array,
            default: () => [],
        },
        list: {
            type: Object|Array,
            default: () => { return {}; },
        },
    },
    data () {
        return {
            show: false,
            selection: [],
        };
    },
    created () {
        this.selection = this.value.slice(0);

        document.addEventListener('click', this.onClickDocument);
    },
    destroyed () {
        document.removeEventListener('click', this.onClickDocument);
    },
    computed: {
        options () {
            return Object.keys(this.list);
        },
        selectionText () {
            return this.selection.length
                ? this.selection.map(key => this.list[key]).join(', ')
                : 'Select options';
        }
    },
    methods: {
        onClickDocument (e) {
            if (! this.show) return;

            const isToggle = e.path.includes(this.$refs.dropdownToggle);

            if (isToggle) return;

            const isMenu = e.path.includes(this.$refs.dropdownMenu);

            this.show = isMenu;
        },
        onClickOption (option) {
            const index = this.selection
                .findIndex(value => value === option);

            if (index === -1) {
                this.selection.push(option);
            } else {
                this.selection.splice(index, 1);
            }
        },
        onClickToggle () {
            this.show = !this.show;
        },
        realName() {
            // It is possible that the name of the input was changed.
            if (this.$refs.nameInput) {
                return this.$refs.nameInput.name;
            }
        },
    }
};
</script>
