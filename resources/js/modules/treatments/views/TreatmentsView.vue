<template>
  <logged lastView="treatments" />
  <page-title title="Tratamientos" />
  <treatments-table v-if="treatments" :treatments="treatments" @view="view" />
    <button-new @new="newTreatment">
      <i class="fa-solid fa-heart-circle-plus"></i>
    </button-new>
  <treatment-modal v-if="showModal" :treatment="activeTreatment"
    @hide="showModal=false"
    @deleteTreatment="deleteTreatment"
    @saveTreatment="saveTreatment"
  />
</template>

<script>
import Logged from "../../auth/components/Logged.vue"
import PageTitle from "../../../components/PageTitle.vue"
import TreatmentsTable from "../components/TreatmentsTable.vue"
import TreatmentModal from '../components/TreatmentModal.vue'
import ButtonNew from '../../../components/ButtonNew.vue'

import { mapState } from "vuex"
import { 
  getTreatments,
  getTreatment,
  addTreatment,
  saveTreatment,
  deleteTreatment 
  } from "../helpers/TreatmentDAO.js"
import { Treatment } from '../../../helpers/Treatment.js'

export default {
  data() {
    return {
      treatments: [],
      activeTreatment: new Treatment({}),
      showModal: false
    };
  },
  components: {
    Logged,
    PageTitle,
    TreatmentsTable,
    TreatmentModal,
    ButtonNew
  },
  computed: {
    ...mapState("auth", ["apiKey"]),
  },
  methods:{
    async view(id){
      const result = await getTreatment(this.apiKey, id)
      this.activeTreatment = new Treatment( result.data )
      console.log(this.activeTreatment)
      this.showModal = true
    },
    async saveTreatment(){
      let response
      if(this.activeTreatment.id){
        response = await saveTreatment(this.apiKey, this.activeTreatment)
      } else {
        response = await addTreatment(this.apiKey, this.activeTreatment)
      }
      console.log(response);
      this.activeTreatment = new Treatment({});
      this.showModal = false;
      this.refreshData()
    },
    async deleteTreatment(id){
      await deleteTreatment(this.apiKey, id)
      this.activeTreatment = new Treatment({})
      this.showModal = false
      this.refreshData()
    },
    async refreshData(){
      if (this.apiKey) {
        const { data } = await getTreatments(this.apiKey)
        this.treatments = data
      }
    },
    newTreatment(){
      this.activeTreatment = new Treatment({})
      this.showModal = true
    }
  },
  mounted() {
    this.refreshData()
  },
};
</script>

<style>
</style>