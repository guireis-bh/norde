<template>
    <div id="address-from">
        <h1>Endereço</h1>
        <div class="col-md-6">
            <div class="form-group">
                <label>CEP</label>
                {{ address.postalcode }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Cidade</label>
                {{ address.city }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Rua</label>
                {{ address.street }}
            </div>
        </div>
            <div class="col-md-6">
            <div class="form-group">
                <label>Número</label>
                {{ address.number }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Bairro</label>
                {{ address.district }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Complemento</label>
                {{ address.complement }}
            </div>
        </div>
        <div class="row">
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Estado</label>
                {{ address.state }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Pais</label>
                {{ address.country }}
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
    name: 'BlockAddressView',
    props: {
        id: {
            type: Number,
            required: true
        }
    },
    computed: {
        ...mapGetters([
            'addressByID'
        ]),
        address() {
            return this.addressByID(this.id)
        }
    },
    methods: {
        ...mapActions([
            'loadAddress'
        ]),
        load() {
            this.loadAddress()
        }
    },
    mounted() {
        this.load()
    },
}
</script>