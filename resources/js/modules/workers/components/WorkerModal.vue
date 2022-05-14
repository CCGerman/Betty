<template>
<div class="w-100 h-100 position-fixed top-0 start-0 bg-80 d-flex align-middle overflow-scroll py-5 modal-element">
    <div class="bg-white m-auto p-4 col-11 col-sm-10 col-md-8 col-lg-4 col-xl-3">
        <div class="row mb-2 justify-content-between align-vertical">
            <h3 class="col-8 my-1">{{ title }}</h3>
            <button v-if="worker.id" class="btn btn-outline-danger col-2" @click="deleteWorker">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text col-12 col-sm-4" id="name-addon">Nombre</span>
            <input type="text" class="form-control" :class="{'is-invalid': errors.name}"
            id="name" placeholder="Nombre" v-model="worker.name" aria-describedby="name-addon">
            <div v-if="errors.name" class="invalid-feedback">
                {{ errors.name }}
            </div>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text col-12 col-sm-4" id="last-name-1-addon">Apellido 1</span>
            <input type="text" class="form-control" :class="{'is-invalid' : errors.last_name_1}"
            id="last_name_1" placeholder="Primer apellido" v-model="worker.last_name_1"
            aria-describedby="last-name-1-addon">
            <div v-if="errors.last_name_1" class="invalid-feedback">
                {{ errors.last_name_1 }}
            </div>        
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text col-12 col-sm-4" id="last-name-2-addon">Apellido 2</span>
            <input type="text" class="form-control" id="last_name_2"
            placeholder="Segundo apellido" v-model="worker.last_name_2"
            aria-describedby="last-name-2-addon">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text col-12 col-sm-4" id="phone-addon">Teléfono</span>
            <input type="text" class="form-control" id="phone" :class="{'is-invalid' : errors.phone}"
            placeholder="Teléfono" v-model="worker.phone" aria-describedby="phone-addon">
            <div v-if="errors.phone" class="invalid-feedback">
                {{ errors.phone }}
            </div>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text col-12 col-sm-4" id="mail-addon">@Mail</span>
            <input type="email" class="form-control" id="email" :class="{'is-invalid' : errors.email}"
            placeholder="E-mail" v-model="worker.email" aria-describedby="mail-addon">
            <div v-if="errors.email" class="invalid-feedback">
                {{ errors.email }}
            </div>
        </div>
        <div class="input-group mb-3">
            <label class="form-label-sm col-12">Dirección</label>
            <div class="input-group mb-1">
                <span class="input-group-text col-12 col-sm-4" id="address_1-addon">Línea 1</span>
                <input type="text" class="form-control" id="address1" :class="{'is-invalid' : errors.address1}"
                placeholder="Línea 1" v-model="worker.address.address_1" aria-describedby="address_1-addon">
                <div v-if="errors.address_1" class="invalid-feedback">
                    {{ errors.address_1 }}
                </div>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text col-12 col-sm-4" id="address-addon">Línea 2</span>
                <input type="text" class="form-control" id="address2" placeholder="Línea 2" v-model="worker.address.address_2" aria-describedby="address-addon">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text col-12 col-sm-4" id="city-addon">Localidad</span>
                <input type="text" class="form-control" id="city"  :class="{'is-invalid' : errors.city}"
                placeholder="Localidad" v-model="worker.address.city" aria-describedby="address-addon">
                <div v-if="errors.city" class="invalid-feedback">
                    {{ errors.city }}
                </div>
            </div>
            <div class="row ">
                <div class="input-grup col-4">
                    <label for="postalcode" class="form-label">C.P.</label>
                    <input type="text" class="form-control" id="postalcode"
                    :class="{'is-invalid': errors.postalcode}"
                    placeholder="CP" v-model="worker.address.postalcode">       
                </div>
                <div class="input-grup col-8">
                    <label for="country" class="form-label">País</label>
                    <input type="text" class="form-control" id="country"
                     :class="{'is-invalid': errors.country}"
                    placeholder="País" v-model="worker.address.country">       
                </div>
                <div v-if="errors.country" class="invalid-feedback">
                    {{ errors.country }}
                </div>
             </div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="form-check d-flex align-middle">
                <input class="form-check-input" type="checkbox" id="active"
                v-model="worker.active" true-value=1 false-value=0 checked>
                <label for="active" class="ps-2 form-check-label">Activo</label>
            </div>
            <div class="buttons">
                <div class="row mt-2">
                    <button class="btn btn-success d-flex justify-content-evenly col-5 me-2" @click="saveWorker">
                        <i class="py-1 fa-solid fa-circle-check"></i>
                        <span class="d-none d-md-block">Guardar</span>
                    </button>
                    <button class="btn btn-secondary d-flex justify-content-evenly col-5" @click="$emit('hide')">
                    <i class="py-1 fa-solid fa-right-from-bracket"></i>
                    <span class="d-none d-md-block">Salir</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import Swal from 'sweetalert2'
import { Worker } from '../../../helpers/Worker.js'

export default {
    data(){
        return {
            errors: []
        }
    },
    props: {
        worker: {
            type: Worker,
            required: true,
            default: new Worker({})
        },
    },
    methods: {
        deleteWorker(){
            Swal.fire({
                title: '¿Eliminar el trabajador?',
                text: "Esta opción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#3085d6',
                confirmButtonColor: '#d33',
                confirmButtonText: '¡Eliminar!',
                cancelButtonText: 'Volver'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.$emit('deleteWorker', this.worker.id)
                }
            })
        },
        validateForm(){
            this.errors = {}
            if (!this.worker.name) {
                this.errors.name = 'El nombre es obligatorio.'
            }
            if (!this.worker.last_name_1) {
                this.errors.last_name_1 = 'El primer apellido es obligatorio.'
            }
            if (!this.worker.phone) {
                this.errors.phone = 'El teléfono es obligatorio.'
            }
            if (!this.worker.email) {
                this.errors.email = 'El email es obligatorio.'
            }
            if (!this.worker.address.address_1) {
                this.errors.address_1 = 'La línea 1 en la direccion es obligatoria.'
            }
            if (!this.worker.address.city) {
                this.errors.city = 'La localidad es obligatoria.'
            }
            if (!this.worker.address.postalcode) {
                this.errors.postalcode = 'El código postal es obligatorio'
            }
            if (!this.worker.address.country) {
                this.errors.country = 'El país es obligatorio.'
            }
            if(Object.keys(this.errors).length == 0) return true
            else return false
        },
        saveWorker(){
            if(this.validateForm()){
                this.$emit('saveWorker')
            }
        },
    },
    computed: {
        title(){
            if(this.worker.id) return "Editar trabajador"
            else return "Nuevo trabajador"
        }
    }
}
</script>

<style>

.bg-80{
    background-color: rgba(0,0,0,.8);
}

</style>