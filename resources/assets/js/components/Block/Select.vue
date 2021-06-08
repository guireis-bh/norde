<template>
    <div class="form-group" :class="{ 'has-error': error }">
        <label v-if="label !== false">{{ label }}</label>

        <select :id="id" class="form-control" :value="model" @change="$emit('update:model', $event.target.value); change()">
            <option value="" v-if="empty !== false">{{ empty }}</option>
            <option v-for="option in options" :value="option.value">{{ option.text }}</option>
        </select>
        <p v-if="typeof info === 'string'">
            {{ info }}
        </p>
        <p v-else-if="info !== false">
            <router-link :to="{name: info.route}">{{ info.text }}</router-link>
        </p>
    </div>
</template>

<script>
export default {
    name: 'BlockSelect',
    props: {
        id: {
            type: String,
            required: true
        },
        options: {
            type: Array,
            required: true
        },
        error: {
            type: Boolean,
            required: false
        },
        model: {
            type: [String, Number, Object],
            required: true
        },
        label: {
            type: [String, Boolean],
            default: false
        },
        empty: {
            type: [String, Boolean],
            default: false
        },
        info: {
            type: [Object, Boolean, String],
            default: false
        },
        change: {
            type: Function,
            required: false,
            default: () => {}
        },
        disabled: Boolean
    }
}
</script>