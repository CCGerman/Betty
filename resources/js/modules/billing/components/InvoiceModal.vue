<template>
<div class="w-100 h-100 position-fixed top-0 start-0 bg-80 d-flex align-middle overflow-scroll py-5 modal-element">
    <div class="bg-white m-auto p-4 col-11 col-sm-10 col-md-8 col-lg-4 col-xl-3">
        <div class="row mb-2 justify-content-between align-vertical">
            <h3 class="col-8 my-1">{{ title }}</h3>
            <button v-if="invoice.id" class="btn btn-outline-danger col-2" @click="deleteInvoice">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
       <!-- form -->
        <div class="d-flex justify-content-between">
            <div class="buttons">
                <div class="row mt-2">
                    <button class="btn btn-success d-flex justify-content-evenly col-5 me-2" @click="saveInvoice">
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
import { Invoice } from '../../../helpers/Invoice.js'

export default {
    data(){
        return {
            errors: []
        }
    },
    props: {
        invoice: {
            type: Invoice,
            required: true,
            default: new Invoice({})
        },
    },
    methods: {
        deleteInvoice(){
            Swal.fire({
                title: '¿Eliminar la factura?',
                text: "Esta opción generará una factura rectificativa",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#3085d6',
                confirmButtonColor: '#d33',
                confirmButtonText: '¡Eliminar!',
                cancelButtonText: 'Volver'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.$emit('deleteInvoice', this.invoice.id)
                }
            })
        },
        validateForm(){
            this.errors = {}

            // Implement form validation

            if(Object.keys(this.errors).length == 0) return true
            else return false
        },
        saveInvoice(){
            if(this.validateForm()){
                this.$emit('saveInvoice')
            }
        },
    },
    computed: {
        title(){
            if(this.invoice.id) return "Editar factura"
            else return "Nueva factura"
        }
    }
}
</script>

<style>

.bg-80{
    background-color: rgba(0,0,0,.8);
}

</style>