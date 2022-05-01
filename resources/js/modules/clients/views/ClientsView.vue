<template>
  <logged lastView="clients" />
  <page-title title="clientes" />
  <clients-table v-if="clients" :clients="clients" @view="view" />
  <button-new @new="newUser">
    <i class="fa-solid fa-user-plus"></i>
  </button-new>
  <client-modal v-if="showModal" :client="activeClient"
    @hide="showModal=false"
    @deleteClient="deleteClient"
    @saveClient="saveClient"
  />
</template>

<script>
import Logged from "../../auth/components/Logged.vue"
import PageTitle from "../../../components/PageTitle.vue"
import ClientsTable from "../components/ClientsTable.vue"
import ClientModal from '../components/ClientModal.vue'
import ButtonNew from '../../../components/ButtonNew.vue'

import { mapState } from "vuex"
import { 
  getClients,
  getClient,
  addClient,
  saveClient,
  deleteClient 
  } from "../helpers/ClientDAO.js"
import { Client } from '../../../helpers/Client.js'

export default {
  data() {
    return {
      clients: [],
      activeClient: new Client({}),
      showModal: false
    };
  },
  components: {
    Logged,
    PageTitle,
    ClientsTable,
    ClientModal,
    ButtonNew
  },
  computed: {
    ...mapState("auth", ["apiKey"]),
  },
  methods:{
    async view(id){
      const result = await getClient(this.apiKey, id)
      this.activeClient = new Client( result.data )
      console.log(this.activeClient)
      this.showModal = true
    },
    async saveClient(){
      let response
      if(this.activeClient.id){
        response = await saveClient(this.apiKey, this.activeClient)
      } else {
        response = await addClient(this.apiKey, this.activeClient)
      }
      this.activeClient = new Client({});
      this.showModal = false;
      this.refreshData()
    },
    async deleteClient(id){
      await deleteClient(this.apiKey, id)
      this.activeClient = new Client({})
      this.showModal = false
      this.refreshData()
    },
    async refreshData(){
      if (this.apiKey) {
        const { data } = await getClients(this.apiKey)
        this.clients = data
      }
    },
    newUser(){
      this.activeClient = new Client({})
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