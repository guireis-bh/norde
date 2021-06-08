<template>
    <div id="address-from">
        <h1>Endereço</h1>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.postalcode }">
                <label>CEP</label>
                <input id="postalcode" name="postalcode" v-model="inputs.postalcode" v-mask="'#####-###'" placeholder="00000-000" type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.city }">
                <label>Cidade</label>
                <input id="city" name="city" v-model="inputs.city" type="text" ref="logradouro" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.street }">
                <label>Rua</label>
                <input id="street" name="street" v-model="inputs.street" type="text" class="form-control">
            </div>
        </div>
            <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.number }">
                <label>Número</label>
                <input id="number" name="number" v-model="inputs.number" type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.district }">
                <label>Bairro</label>
                <input id="district" name="district" v-model="inputs.district" type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.complement }">
                <label>Complemento</label>
                <input id="complement" name="complement" v-model="inputs.complement" type="text" class="form-control">
            </div>
        </div>
        <div class="row">
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.state }">
                <label>Estado</label>
                <input id="state" name="state" v-model="inputs.state" type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.country }">
                <label>Pais</label>
                <select id="country" name="country" v-model="inputs.country" class="form-control">
                    <option>Brasil</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
import { mask } from 'vue-the-mask'

export default {
    name: 'BlockAddressForm',
    data() {
        return {
            inputs: {
                id: null,
                postalcode: "",
                city: "",
                street: "",
                number: "",
                district: "",
                complement: "",
                state: "",
                country: ""
            },
            hasError: {
                postalcode: false,
                city: false,
                street: false,
                number: false,
                district: false,
                complement: false,
                state: false,
                country: false
            }
        }
    },
    props: {
        addressID: {
            type: [Number, Boolean],
            required: false
        }
    },
    methods: {
        ...mapActions([
            'createAddress',
            'updateAddress',
            'loadAddress'
        ]),
        submit() {
            this.hasError = {
                postalcode: false,
                city: false,
                street: false,
                number: false,
                district: false,
                complement: false,
                state: false,
                country: false
            }
            return new Promise(resolve => {
                    resolve(this.inputs.id ? 
                        this.updateAddress(this.inputs) : this.createAddress(this.inputs))
                })
                .then(res => {
                    if(res.status === 201) {
                        this.inputs.id = res.data.id
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
                })
        },
        searchCep() {
            if (/^[0-9]{5}-[0-9]{3}$/.test(this.cep) || /^[0-9]{8}$/.test(this.cep)){
                axios.get('http://viacep.com.br/ws/' + this.cep + '/json/')
                .then(({ data }) => {
                    this.endereco = data
                    this.endereco.cep = this.cep.replace(/\D/g,'');
                    return data                       
                }).catch(err => {
                    console.log('CEP não localizado' + err)
                })
            }
        },
        load() {
            this.loadAddress()
        }
    },
    beforeMount() {
        this.load()
        if(this.addressID) {
            let address = this.$store.getters.addressByID(this.addressID)
            this.inputs.id = address.id
            this.inputs.postalcode = address.postalcode
            this.inputs.city = address.city
            this.inputs.street = address.street
            this.inputs.number = address.number
            this.inputs.district = address.district
            this.inputs.complement = address.complement
            this.inputs.state = address.state
            this.inputs.country = address.country
        }
    },
    directives: {
        mask
    }
}
</script>