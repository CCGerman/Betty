import { Client } from "./Client"
import { Worker } from "./Worker"
import { Treatment } from "./Treatment" 
import { AppointmentEvent } from "./AppointmentEvent"

export class Appointment{

    create( appointmentEvent ){

        this.id = appointmentEvent.id
        this.start = appointmentEvent.time_start 
        this.end = appointmentEvent.time_end
        if(appointmentEvent.client)
            this.client = appointmentEvent.client
        else this.client = new Client({id: appointmentEvent.client_id})
        if(appointmentEvent.worker)
            this.worker = appointmentEvent.worker
        else this.worker = new Worker({id: appointmentEvent.worker_id})
        if(appointmentEvent.treatment)
            this.treatment = appointmentEvent.treatment
        else this.treatment = new Treatment({id: appointmentEvent.treatment_id})
    }

    getEvent() {
        return new AppointmentEvent(this)
    }


    createFromCalendar( event, client, worker, treatment ){

        this.id = event.id
        this.start = event.start || new Date()
        this.end = event.end || new Date()
        this.client = client
        this.worker = worker
        this.treatment = treatment
    }

}