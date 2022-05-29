<template>
  <logged lastView="billing" />
  <page-title title="facturación" />
  <invoices-table v-if="invoices" :invoices="invoices" @view="view" />
  <button-new @new="newUser">
    <i class="fa-solid fa-user-plus"></i>
  </button-new>
  <invoice-modal v-if="showModal" :invoice="activeInvoice"
    @hide="showModal=false"
    @deleteInvoice="deleteInvoice"
    @saveInvoice="saveInvoice"
  />
</template>

<script>
import Logged from "../../auth/components/Logged.vue"
import PageTitle from "../../../components/PageTitle.vue"
import InvoicesTable from "../components/InvoicesTable.vue"
import InvoiceModal from '../components/InvoiceModal.vue'
import ButtonNew from '../../../components/ButtonNew.vue'

import { mapState } from "vuex"
import {  
  getInvoices,
  getInvoice,
  addInvoice,
  saveInvoice,
  deleteInvoice 
  } from "../helpers/InvoiceDAO.js"
import { Invoice } from '../../../helpers/Invoice.js'

export default {
  data() {
    return {
      invoices: [],
      activeInvoice: new Invoice({}),
      showModal: false
    };
  },
  components: {
    Logged,
    PageTitle,
    InvoicesTable,
    InvoiceModal,
    ButtonNew
  },
  computed: {
    ...mapState("auth", ["apiKey"]),
  },
  methods:{
    async view(id){
      const result = await getInvoice(this.apiKey, id)
      this.activeInvoice = new Invoice( result.data )
      console.log(this.activeInvoice)
      this.showModal = true
    },
    async saveInvoice(){
      let response
      if(this.activeInvoice.id){
        response = await saveInvoice(this.apiKey, this.activeInvoice)
      } else {
        response = await addInvoice(this.apiKey, this.activeInvoice)
      }
      this.activeInvoice = new Invoice({});
      this.showModal = false;
      this.refreshData()
    },
    async deleteInvoice(id){
      await deleteInvoice(this.apiKey, id)
      this.activeInvoice = new Invoice({})
      this.showModal = false
      this.refreshData()
    },
    async refreshData(){
      if (this.apiKey) {
        const { data } = await getInvoices(this.apiKey)
        this.invoices = data
      }
    },
    newUser(){
      this.activeInvoice = new Invoice({})
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