<template>
  <logged lastView="appointments" />
  <page-title title="Citas" />
  <calendar
    :appointments="appointments"
    @editEvent="editAppointment"
  />
  <appointment-modal
    v-if="showModal"
    :appointment="activeAppointment"
    @hide="showModal=false"
    @deleteAppointment="deleteAppointment"
    @saveAppointment="saveAppointment"
  />
  <button-new @new="newAppointment">
    <i class="fa-solid fa-calendar-plus"></i>
  </button-new>
</template>

<script>
import { mapState } from 'vuex'
import Logged from "../../auth/components/Logged.vue"
import PageTitle from "../../../components/PageTitle.vue"
import ButtonNew from "../../../components/ButtonNew.vue"
import Calendar from "../components/Calendar.vue"
import { Appointment } from "../../../helpers/Appointment.js"
import AppointmentModal from "../components/AppointmentModal.vue"
import {
  getAppointments,
  getAppointment,
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
      showModal: false
    }
  },
  methods: {
    async refreshData(){
      if(this.apiKey){
        const { data } = await getAppointments(this.apiKey)
        const appointments = []
        for(const appointmentData of data){
          appointments.push(new Appointment(appointmentData))
        }
        this.appointments = appointments
      }
    },
    newAppointment() {
      this.activeAppointment = new Appointment({})
      this.showModal = true
    },
    editAppointment(appointment){
      this.activeAppointment = appointment
      this.showModal = true
    },
    saveAppointment(){
      console.log('guardarCita')
      this.showModal = false
    },
    deleteAppointment(){

    }
  },
  computed: {
    ...mapState("auth", ["apiKey"]),
  },
  mounted(){
    this.refreshData()
  }
};
</script>

<style>
</style>