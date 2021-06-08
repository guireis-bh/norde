<template>
    <div class="col-md-12">
        <div class="form-group form-typehead" :class="{ 'has-error': hasError.name }">
            <label>Nome da familia *</label>
            <input
                id="family"
                name="family"
                :value="inputs.name"
                type="text"
                class="form-control"
                placeholder="Nome da familia (ex: 'Familia Silva, Os Souza')."
                v-on:keypress.enter.prevent="supress"
            >
            <uiv-typehead v-model="inputs" target="#family" :data="families" item-key="name" />
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import { Typeahead } from 'uiv'

export default {
    name: 'BlockFamily',
    data() {
        return {
            inputs: {
                id: null,
                name: null
            },
            hasError: {
                name: false
            }
        }
    },
    computed: {
        ...mapGetters([
            'families'
        ])
    },
    props: {
        familyID: {
            type: [Number, Boolean],
            required: false
        }
    },
    methods: {
        ...mapActions([
            'createFamily',
            'updateFamily',
            'loadFamilies'
        ]),
        submit() {
            this.hasError = {
                name: false
            }
            return new Promise((resolve, reject) => {
                    resolve(this.inputs.id ?
                        this.updateFamily(this.inputs) : this.createFamily({ name: this.inputs }))
                })
                .then(res => {
                    if(res.status === 201) {
                        this.inputs = res.data
                        this.loadFamilies(true)
                        return res.data
                    }
                })
                .catch(err => {
                    if(typeof err.data !==  'undefined') {
                        Object.keys(err.data).forEach(key => {
                            this.hasError[key] = true
                        })
                    } else {
                        console.error(err)
                    }
                    throw err
                })
        },
        supress(e) {
            e.preventDefault()
        },
        load () {
            this.loadFamilies()
            if(this.familyID) {
                let family = this.$store.getters.familyByID(this.familyID)
                this.inputs.id = family.id
                this.inputs.name = family.name
            }
        },
    },
    beforeMount() {
        this.load()
        if(this.addressID) {
            let family = this.$store.getters.familyByID(this.familyID)
            this.inputs.id = family.id
            this.inputs.name = family.name
        }
    },
    components: {
        'uiv-typehead': Typeahead
    }
}
</script>