<template>
    <div class="form-group" :class="{ 'has-error': error }">
        <label v-if="label !== false">{{ label }}</label>
        <vue-tags-input
            v-model="tag"
            :tags="tags"
            :autocomplete-items="subjects"
            @tags-changed="newTags"
            placeholder="Escolha seus assuntos"
        />
        <p v-if="typeof info === 'string'">
            {{ info }}
        </p>
        <p v-else-if="info !== false">
            <router-link :to="{name: info.route}">{{ info.text }}</router-link>
        </p>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
import VueTagsInput from '@johmun/vue-tags-input';

export default {
    name: 'BlockSubjectForm',
    data() {
        return {
            tag: '',
            tags: []
        }
    },
    props: {
        id: {
            type: String,
            default: 'subject'
        },
        error: {
            type: Boolean,
            required: false
        },
        label: {
            type: [String, Boolean],
            default: false
        },
        info: {
            type: [Object, Boolean, String],
            default: false
        },
        userID:{
            type: [Number, Boolean],
            required: false,
            default: false
        }
    },
    computed: {
        subjects() {
            let subjects = this.$store.getters.subjects
            let results = []
            subjects.forEach((el, inx) => {
                results[inx] = {
                    id: el.id,
                    text: el.name
                }
            })
            return results;
        }
    },
    methods: {
        ...mapActions([
            'loadSubjects',
            'getSubjectsByUser',
            'createSubjects'
        ]),
        newTags(newTags) {
            if(newTags.length === 0) {
                this.tags = []
                return
            }
            let lastTag = newTags.length - 1
            if(!this.subjects.filter(subject => subject.text == newTags[lastTag].text).length) {
                this.createSubjects({name: newTags[lastTag].text})
                    .then(res => {
                        newTags[lastTag] = {
                            id: res.data.id,
                            text: res.data.name
                        }
                        this.tags = newTags
                        this.loadSubjects(true)
                    })
            }
        },
        getIDs() {
            let ids = []
            this.tags.forEach(el => {
                ids.push(el.id)
            })
            return ids;
        },
        load() {
            this.loadSubjects()
            if(this.userID) {
                this.getSubjectsByUser(this.userID)
                    .then(res => {
                        if(res.status === 200) {
                            res.data.forEach(el => {
                                this.tags.push({
                                    id: el.id,
                                    text: el.name
                                })
                            })
                        }
                    })
            }
        }
    },
    mounted() {
        this.load()
    },
    components: {
        VueTagsInput
    }
}
</script>