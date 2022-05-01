<template>
<div class="w-100 h-100 position-fixed top-0 start-0 bg-80 d-flex align-middle overflow-scroll py-5 modal-element">
    <div class="bg-white m-auto p-4 col-11 col-sm-10 col-md-8 col-lg-4 col-xl-3">
        <div class="row mb-2 justify-content-between align-vertical">
            <h3 class="col-8 my-1">{{ title }}</h3>
            <button v-if="appointment.id" class="btn btn-outline-danger col-2" @click="deleteAppointment">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>

        <div class="d-flex justify-content-between">
            <div class="form-check d-flex align-middle">
                <input class="form-check-input" type="checkbox" id="active"
                v-model="appointment.active" true-value=1 false-value=0>
                <label for="active" class="ps-2 form-check-label">Activo</label>
            </div>
            <div class="buttons">
                <div class="row mt-2">
                    <button class="btn btn-success d-flex justify-content-evenly col-5 me-2" @click="saveAppointment">
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
import { Appointment } from '../../../helpers/Appointment.js'

export default {
    data(){
        return {
            errors: []
        }
    },
    props: {
        appointment: {
            type: Appointment,
            required: true,
            default: new Appointment({})
        },
    },
    methods: {
        deleteAppointment(){
            Swal.fire({
                title: '¿Eliminar la cita?',
                text: "Esta opción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#3085d6',
                confirmButtonColor: '#d33',
                confirmButtonText: '¡Eliminar!',
                cancelButtonText: 'Volver'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.$emit('deleteAppointment', this.appointment.id)
                }
            })
        },
        validateForm(){
            this.errors = {}
            /*if (!this.appointment.name) {
                this.errors.name = 'El nombre es obligatorio.'
            }*/

            //Validation forms

            if(Object.keys(this.errors).length == 0) return true
            else return false
        },
        saveAppointment(){
            if(this.validateForm()){
                this.$emit('saveAppointment')
            }
        },
    },
    computed: {
        title(){
            if(this.appointment.id) return "Editar cita"
            else return "Nueva cita"
        }
    }
}
</script>

<style>

.bg-80{
    background-color: rgba(0,0,0,.8);
}

</style>