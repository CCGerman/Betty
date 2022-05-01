<template>
  <vue-cal
    locale="es"
    active-view="week"
    :disable-views="['years', 'year']"
    :snap-to-time="15"
    editable-events
    :events="events"
    :split-days="[
      { id: 10, label: 'Dr 1' },
      { id: 12, label: 'Dr 2' },
    ]"
    class="vuecal--full-height-delete"
    :on-event-dblclick="onEventClick"
  />
</template>

<script>
import VueCal from "vue-cal";
import "vue-cal/dist/vuecal.css";

export default {
  components: {
    VueCal,
  },
  props: {
    appointments: {
      type: Array,
      default: []
    },
  },
  methods: {
      onEventClick(event, e){
        const appointment = this.appointments.find(v => v.id === event.id)
        this.$emit('editEvent', appointment)
        e.stopPropagation()
      }
  },
  computed: {
    events(){
      const events = []
      for(let appointment of this.appointments){
          events.push(appointment.getEvent())
      }
      return events
    }
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

</style>