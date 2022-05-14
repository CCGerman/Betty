<template>
  <logged lastView="settings" />
  <page-title title="Editar" />

  <h3 class="text-center">Técnicos</h3>
  <workers-table v-if="workers" :workers="workers" @view="view" @new="newUser" />
  <worker-modal v-if="showModal" :worker="activeWorker" @hide="showModal = false" @deleteWorker="deleteWorker"
    @saveWorker="saveWorker" />

  <h3 class="mt-5 text-center">Horario</h3>
  <div class="mx-auto d-flex justify-content-between flex-wrap col-12 col-md-8">
    <div class="col-12 col-sm-4 mb-2">
      <span class="input-group-text" id="name-addon">Desde</span>
      <input type="time" class="form-control" :class="{ 'is-invalid': errors.open || errors.timming }" id="name" placeholder="open"
        aria-describedby="name-addon" v-model="open">
      <div v-if="errors.open" class="invalid-feedback">
        {{ errors.open }}
      </div>
    </div>
    <div class="col-12 col-sm-4 mb-2">
      <span class="input-group-text" id="name-addon">Hasta</span>
      <input type="time" class="form-control" :class="{ 'is-invalid': errors.close || errors.timming }" id="name" placeholder="close"
        aria-describedby="name-addon" v-model="close">
      <div v-if="errors.close" class="invalid-feedback">
        {{ errors.close }}
      </div>
    </div>
    <div class="d-flex justify-content-center col-12 col-sm-2 md-2"
      :class="{ 'is-invalid': errors.timming }">
      <button @click="saveTimming" class="btn btn-primary">Guardar</button>
    </div>
    <div v-if="errors.timming" class="invalid-feedback">
      {{ errors.timming }}
    </div>
  </div>
</template>

<script>
import Logged from "../../auth/components/Logged.vue"
import PageTitle from "../../../components/PageTitle.vue"
import WorkersTable from "../../workers/components/WorkersTable.vue"
import WorkerModal from '../../workers/components/WorkerModal.vue'

import { mapGetters, mapActions, mapState } from "vuex"
import {
  getWorkers,
  getWorker,
  addWorker,
  saveWorker,
  deleteWorker
} from "../../workers/helpers/WorkerDAO.js"
import { Worker } from '../../../helpers/Worker.js'


export default {
  data() {
    return {
      workers: [],
      activeWorker: new Worker({}),
      showModal: false,
      errors: [],
      open: '00:00',
      close: '00:00'
    };
  },
  components: {
    Logged,
    PageTitle,
    WorkersTable,
    WorkerModal,
  },
  computed: {
    ...mapState("auth", ["apiKey"]),
    ...mapState('settings', ['settings']),
    ...mapGetters('settings', ['getProperty']),
    openTime() {
      return this.getProperty('open')
    },
    closeTime() {
      return this.getProperty('close')
    },
  },
  methods: {
    ...mapActions('settings', ['setSettings']),
    async saveTimming() {
      this.errors = {};

      if (!this.open) {
        this.errors.open = "Campo obligatorio";
      }

      if (!this.close) {
        this.errors.close = "Campo obligatorio";
      }
      console.log(this.open >= this.close)
      if (this.open >= this.close) {
        this.errors.timming = "Verifique la hora de apertura y cierre";
      }

      if (Object.keys(this.errors).length == 0)
        await this.setSettings({
          apiKey: this.apiKey, settings: [
            { key: 'open', value: this.open },
            { key: 'close', value: this.close }
          ]
        })
    },
    async view(id) {
      const result = await getWorker(this.apiKey, id)
      this.activeWorker = new Worker(result.data)
      this.showModal = true
    },
    async saveWorker() {
      let response
      if (this.activeWorker.id) {
        response = await saveWorker(this.apiKey, this.activeWorker)
      } else {
        response = await addWorker(this.apiKey, this.activeWorker)
      }
      this.activeWorker = new Worker({});
      this.showModal = false;
      this.refreshData()
    },
    async deleteWorker(id) {
      await deleteWorker(this.apiKey, id)
      this.activeWorker = new Worker({})
      this.showModal = false
      this.refreshData()
    },
    async refreshData() {
      if (this.apiKey) {
        const { data } = await getWorkers(this.apiKey)
        this.workers = data
      }
      if (this.settings) {
        this.open = this.settings.open
        this.close = this.settings.close
      }
    },
    newUser() {
      this.activeWorker = new Worker({})
      this.showModal = true
    }
  },
  watch: {
    settings() {
      console.log(this.settings)
      //this.open = this.settings.open.value
      //this.close = this.settings.close.value
    },
    openTime() {
      this.open = this.openTime
    },
    closeTime() {
      this.close = this.closeTime
    },
  },
  async mounted() {
    await this.refreshData()
    this.open = this.openTime
    this.close = this.closeTime
  },
};
</script>

<style>
</style>