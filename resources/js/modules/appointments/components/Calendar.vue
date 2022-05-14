<template>
<div class="buttons mb-2 d-flex justify-content-evenly">
  <button class="btn btn-outline-primary" @click="$refs.vuecal.previous()">Anterior</button>
  <button class="btn btn-outline-primary" @click="$refs.vuecal.switchView('day', new Date())">Hoy</button>
  <button class="btn btn-outline-primary" @click="$refs.vuecal.next()">Siguiente</button>  
</div>
  <vue-cal
    ref="vuecal"
    locale="es"
    active-view="week"
    :disable-views="['years', 'year']"
    :snap-to-time="15"
    :time-from="openTime"
    :time-to="closeTime"
    :time-step="30"
    :editable-events="{ title: false, drag: true, resize: true, delete: false, create: true }"
    :events="events"
    :split-days="workers"
    class="vuecal--full-height-delete"
    :on-event-dblclick="editEvent"
    @event-drag-create="onDragEventCreate($event)"  
    @event-drop="editEvent($event.event)"
    @event-duration-change="editEvent($event.event)"/>
</template>

<script>
import VueCal from "vue-cal";
import "vue-cal/dist/vuecal.css";

import { getWorkers } from '../../workers/helpers/WorkerDAO.js'
import { mapState } from 'vuex'

export default {
  components: {
    VueCal,
  },
  emits: ['editEvent', 'createEvent', 'deleteEvent'],
  data(){
    return {
      workers: []
    }
  },
  props: {
    appointments: {
      type: Array,
      default: []
    },
    open: {
      type: String,
      default: '08:00'
    },
    close: {
      type: String,
      default: '20:00'
    }
  },
  methods: {
      editEvent(event, e){
        this.$emit('editEvent', event)
        if(e) e.stopPropagation()
      },
      onDragEventCreate(event, deleteEventFunction){
        return this.$emit('createEvent', event)
      },
      async fillWorkers(){
        if(this.apiKey){
          const { data } = await getWorkers(this.apiKey)
          this.workers = data.map( w => ({
            id: w.id,
            label: w.name
          }))
        }
      }
  },
  computed: {
    events(){
      const events = []
      for(let appointment of this.appointments){
          events.push(appointment.getEvent())
      }
      return events
    },
    openTime(){
      const [ hours, minutes ] = this.open.split(':')
      return parseInt(hours)*60+parseInt(minutes)
    },
    closeTime(){
      const [ hours, minutes ] = this.close.split(':')
      return parseInt(hours)*60+parseInt(minutes)
    },
    ...mapState('auth', ['apiKey'])
  },
  mounted(){
    this.fillWorkers()
  }
};
</script>
<style>
  .vuecal__menu,
  .vuecal__cell-events-count {
    background-color: #4250b9;
  }
  .vuecal__title-bar {
    background-color: #e4e5f5;
  }
  .vuecal__cell--today,
  .vuecal__cell--current {
    background-color: rgba(240, 240, 255, 0.4);
  }
  .vuecal:not(.vuecal--day-view) .vuecal__cell--selected {
    background-color: rgba(235, 239, 255, 0.4);
  }
  .vuecal__cell--selected:before {
    border-color: rgba(66, 70, 185, 0.5);
  }
  /* Cells and buttons get highlighted when an event is dragged over it. */
  .vuecal__cell--highlighted:not(.vuecal__cell--has-splits),
  .vuecal__cell-split--highlighted {
    background-color: rgba(197, 195, 255, 0.5);
  }
  .vuecal__arrow.vuecal__arrow--highlighted,
  .vuecal__view-btn.vuecal__view-btn--highlighted {
    background-color: rgba(156, 136, 236, 0.25);
  }

  .vuecal__view-btn.vuecal__view-btn--active{
      color: white;
  }

  .vuecal__view-btn:not(.vuecal__view-btn--active){
      color: rgba(197, 195, 255, 0.5);
  }

  .vuecal__event {
    background-color: rgba(197, 195, 255, 0.5);
    color: black;
  }

  .vuecal__event.vuecal__event--focus{
    background-color: #4250b9;
    color: white;
  }

</style>