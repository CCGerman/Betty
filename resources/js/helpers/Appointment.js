import { Client } from "./Client"
import { Worker } from "./Worker"
import { Treatment } from "./Treatment" 
import { AppointmentEvent } from "./AppointmentEvent"

export class Appointment{

    constructor( appointment ){

        this.id = appointment.id
        this.start = appointment.time_start
        this.end = appointment.time_end
        if(appointment.client)
            this.client = appointment.client
        else this.client = new Client({})
        if(appointment.worker)
            this.worker = appointment.worker
        else this.worker = new Worker({})
        if(appointment.treatment)
            this.treatment = appointment.treatment
        else this.treatment = new Treatment({})
    }

    getEvent() {
        return new AppointmentEvent(this)
    }

}