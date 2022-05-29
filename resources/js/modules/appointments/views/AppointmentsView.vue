<template>
  <logged lastView="appointments" />
  <page-title title="Citas" />
  <calendar
    :appointments="appointments"
    :open="open"
    :close="close"
    @editEvent="editAppointment"
    @createEvent="createAppointment"
    @deleteEvent="deleteAppointment"
  />
  <appointment-modal
    v-if="showModal"
    :appointment="activeAppointment"
    :clients="clients"
    :workers="workers"
    :treatments="treatments"
    @cancel="cancel"
    @deleteAppointment="deleteAppointment"
    @saveAppointment="saveAppointment"
  />
  <button-new @new="newAppointment">
    <i class="fa-solid fa-calendar-plus"></i>
  </button-new>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
import Logged from "../../auth/components/Logged.vue"
import PageTitle from "../../../components/PageTitle.vue"
import ButtonNew from "../../../components/ButtonNew.vue"
import Calendar from "../components/Calendar.vue"
import { Appointment } from "../../../helpers/Appointment.js"
import { getTreatments } from '../../treatments/helpers/TreatmentDAO.js'
import { getClients } from '../../clients/helpers/ClientDAO.js'
import { getWorkers } from '../../workers/helpers/WorkerDAO.js'
import AppointmentModal from "../components/AppointmentModal.vue"
import {
  getAppointments,
  addAppointment,
  saveAppointment,
  deleteAppointment
} from "../helpers/AppointmentDAO.js"

export default {
  components: {
    Logged,
    PageTitle,
    Calendar,
    ButtonNew,
    AppointmentModal
  },
  data(){
    return {
      appointments: [],
      activeAppointment: new Appointment({}),
      clients: [],
      treatments: [],
      workers: [],
      showModal: false
    }
  },
  methods: {
    async refreshData(){
      if(this.apiKey){
        const treatments = await getTreatments(this.apiKey)
        const workers = await getWorkers(this.apiKey)
        const clients = await getClients(this.apiKey)
        this.clients = clients.data.filter( c => c.active )
        this.treatments = treatments.data.filter( t => t.active )
        this.workers = workers.data.filter( w => w.active )
        this.getAppointments()

      }
    },
    async getAppointments(){
        const { data } = await getAppointments(this.apiKey)
        const appointments = []
        for(const appointmentData of data){
          appointmentData.client = this.clients.find( c => c.id == appointmentData.client_id)
          appointmentData.worker = this.workers.find( c => c.id == appointmentData.worker_id)
          appointmentData.treatment = this.treatments.find( c => c.id == appointmentData.treatment_id)
          const _app = new Appointment()
          _app.create(appointmentData)
          appointments.push(_app)
        }
        this.appointments = appointments
    },
    newAppointment() {
      const _app = new Appointment()
      _app.createFromCalendar({}, {}, {}, {})
      this.activeAppointment = _app
      this.showModal = true
    },
    createAppointment(appointment) {
      const client = this.clients.find(c => c.id == appointment.client_id) || {}
      const treatment = this.treatments.find(t => t.id == appointment.treatment_id) || {}
      const worker = this.workers.find(w => w.id == appointment.split) || {}
      const _app = new Appointment()
      _app.createFromCalendar(appointment, client, worker, treatment)
      this.activeAppointment = _app
      this.showModal = true
    },
    editAppointment(appointment){
      this.createAppointment(appointment)
    },
    async saveAppointment(appointment){
      if(appointment.id)
      await saveAppointment(this.apiKey, appointment)
      else await addAppointment(this.apiKey, appointment)
      this.getAppointments()
      this.showModal = false

    },
    deleteAppointment(id){
      deleteAppointment(this.apiKey, id)
      this.getAppointments()
      this.showModal = false
    },
    cancel(){
      this.getAppointments()
      this.showModal = false
    }
  },
  computed: {
    ...mapState("auth", ["apiKey"]),
    ...mapGetters("settings", ["getProperty"]),
    open(){
      return this.getProperty('open')
    },
    close(){
      return this.getProperty('close')
    },
  },
  mounted(){
    this.refreshData()
  }
};
</script>

<style>
</style>