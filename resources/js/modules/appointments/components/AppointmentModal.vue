<template>
    <div class="w-100 h-100 position-fixed top-0 start-0 bg-80 d-flex align-middle overflow-scroll py-5 modal-element">
        <div class="bg-white m-auto p-4 col-11 col-sm-10 col-md-8 col-lg-4 col-xl-3">
            <div class="row mb-2 justify-content-between align-vertical">
                <h3 class="col-8 my-1">{{ title }}</h3>
                <button v-if="appointment.id" class="btn btn-outline-danger col-2" @click="deleteAppointment">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            <div class="input-group mb-3">
                <label class="form-label-sm col-12">Cliente</label>
                <select class="form-select" :class="{'is-invalid': errors.client}"
                    aria-label="Cliente" v-model="appointment.client">
                        <option value="" disabled>Seleccione un cliente</option>
                        <option v-for="client in clients" :key="client.id" :value="client">
                            {{ client.name }}
                        </option>
                </select>
                <div v-if="errors.client" class="invalid-feedback">
                {{ errors.client }}
                </div>
            </div>
            <div class="input-group mb-3">
                <label class="form-label-sm col-12">Tratamiento</label>
                <select class="form-select" :class="{'is-invalid': errors.treatment}"
                    aria-label="Tratamiento" v-model="appointment.treatment"
                    @change="setTreatmentDetails">
                        <option selected disabled>Seleccione un tratamiento</option>
                        <option v-for="treatment in treatments" :key="treatment.id" :value="treatment">
                            {{ treatment.name }}
                        </option>
                </select>
                <div v-if="errors.treatment" class="invalid-feedback">
                    {{ errors.treatment }}
                </div>
            </div>
            <div class="input-group mb-3">
                <label class="form-label-sm col-12">Técnico</label>
                <select class="form-select" :class="{'is-invalid': errors.worker}"
                    aria-label="Técnico" v-model="appointment.worker">
                        <option selected disabled>Seleccione un Técnico</option>
                        <option v-for="worker in workers" :key="worker.id" :value="worker">
                            {{ worker.name }}
                        </option>
                </select>
                <div v-if="errors.worker" class="invalid-feedback">
                    {{ errors.worker }}
                </div>
            </div>
            <div class="row mb-3">
                <div>
                <label class="form-label-sm col-12" for="day">Día</label>
                <input class="form-control" type="date" :class="{'is-invalid': errors.date}"
                    id="day" name="day" v-model="startDate"
                    @change="setDate" required>
                <div v-if="errors.date" class="invalid-feedback">
                    {{ errors.date }}
                </div>
                </div>
            </div>
            <div class="row mb-3" :class="{'is-invalid': errors.hours}">
                <div class="col-6" >
                    <label class="form-label-sm col-12" for="hour">Desde</label>
                    <input class="form-control" :class="{'is-invalid': errors.hours}"
                        type="time" id="hour" name="start_hour"
                        v-model="startTime" required @change="setStartTime">
                </div>
                <div class="col-6" :class="{'is-invalid': errors.hours}">
                    <label class="form-label-sm col-12" for="hour">Hasta</label>
                    <input class="form-control" :class="{'is-invalid': errors.hours}"
                        type="time" id="hour" name="end_hour"
                        v-model="endTime" required @change="setEndTime">
                </div>
                <div v-if="errors.hours" class="invalid-feedback">
                    {{ errors.hours }}
                </div>
            </div>
      <div class="input-group mb-3">
        <span class="input-group-text col-12 col-sm-4" id="price-addon"
          >Precio</span
        >
        <input
          type="text"
          class="form-control"
          :class="{ 'is-invalid': errors.price }"
          id="price"
          placeholder="Precio"
          v-model="price"
          aria-describedby="price-addon"
        />
        <div v-if="errors.price" class="invalid-feedback">
          {{ errors.price }}
        </div>
      </div>
            <div class="d-flex justify-content-end">
                <div class="buttons">
                    <div class="row mt-2">
                        <button class="btn btn-success d-flex justify-content-evenly col-5 me-2"
                            @click="saveAppointment">
                            <i class="py-1 fa-solid fa-circle-check"></i>
                            <span class="d-none d-md-block">Guardar</span>
                        </button>
                        <button class="btn btn-secondary d-flex justify-content-evenly col-5" @click="$emit('cancel')">
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
import { mapGetters, mapState } from 'vuex'

export default {
    data() {
        return {
            errors: [],
            startDate: '',
            startTime: '',
            endTime: '',
            price: ''
        }
    },
    props: {
        appointment: {
            type: Appointment,
            required: true,
        },
        workers: {
            type: Array,
            required: true
        },
        treatments: {
            type: Array,
            required: true
        },
        clients: {
            type: Array,
            required: true
        },
    },
    methods: {
        setTreatmentDetails() {
            this.price = this.treatment.price
            this.setStartTime()
        },
        setDate(){
            const splitted = this.startDate.split('-')
            const year = splitted[0]
            const month = splitted[1]
            const day = splitted[2]
            this.appointment.start.setDate(day)
            this.appointment.end.setDate(day)
            this.appointment.start.setMonth(month)
            this.appointment.end.setMonth(month)
            this.appointment.start.setYear(year)
            this.appointment.end.setYear(year)
        },
        setStartTime() {
            const hours = this.startTime.split(':')[0]
            const minutes = this.startTime.split(':')[1]
            this.appointment.start.setHours(hours)
            this.appointment.start.setMinutes(minutes)
            this.appointment.end = new Date(this.appointment.start.getTime() + (this.treatment.duration * 60 * 1000))
            this.endTime = this.getEndTime
        },
        setEndTime(){
            const hours = this.endTime.split(':')[0]
            const minutes = this.endTime.split(':')[1]
            this.appointment.end.setHours(hours)
            this.appointment.end.setMinutes(minutes)
        },
        deleteAppointment() {
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
        validateForm() {
            this.errors = {}
            if (!this.appointment.client.id) {
                this.errors.client = 'Debe seleccionar un cliente'
            }
            if (!this.appointment.worker.id) {
                this.errors.worker = 'Debe seleccionar un técnico'
            }

            if (!this.appointment.treatment.id) {
                this.errors.treatment = 'Debe seleccionar un tratamiento'
            }

            if (!this.startTime || !this.endTime) {
                this.errors.hours = "Las horas son obligatorias"
            } else if (!(this.endTime > this.startTime)) {
                this.errors.hours = "La hora final no puede ser inferior a la de inicio"
            } else if(this.endTime > this.close || this.startTime < this.open){
                this.errors.hours = "Cita fuera del horario comercial"
            }

            if (!this.startDate) {
                this.errors.date = "El día esobligatorio"
            } else{
                const today = new Date()
                today.setHours(0, 0, 0, 0)
                if (today.valueOf() > this.appointment.start.valueOf()) {
                    this.errors.date = "Fecha anterior a hoy"
                }
            }

            if (!this.treatment.price) {
                this.errors.price = "El precio es obligatorio."
            } else if (isNaN(this.treatment.price) || parseFloat(this.treatment.price) != this.treatment.price) {
                this.errors.price = "El precio debe ser un número"
            }

            //Validation forms

            if (Object.keys(this.errors).length == 0) return true
            else return false
        },
        saveAppointment() {
            if (this.validateForm()) {
                this.$emit('saveAppointment', this.appointment)
            }
        },
        isActiveClient(id) {
            if (this.appointment.client && id == this.appointment.client.id) return 'selected'
            else return ''
        }
    },
    computed: {
        title() {
            if (this.appointment.id) return "Editar cita"
            else return "Nueva cita"
        },
        treatment() {
            return this.appointment.treatment
        },
        getStartDate() {
            return this.appointment.start.toISOString().split('T')[0]
        },
        getStartTime() {
            return this.appointment.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        },
        getEndTime() {
            return this.appointment.end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        },
        ...mapGetters('settings', ['getProperty']),
        open(){
            return this.getProperty('open')
        },
        close(){
            return this.getProperty('close')
        },
    },
    mounted() {
        this.startDate = this.getStartDate
        this.startTime = this.getStartTime
        this.endTime = this.getEndTime
        this.price = this.treatment.price
    }
}
</script>

<style>
.bg-80 {
    background-color: rgba(0, 0, 0, .8)
}
</style>