import { Client } from "./Client"
import { Worker } from "./Worker"
import { Treatment } from "./Treatment" 

export class AppointmentEvent{

    constructor( appointment ){

        this.id = appointment.id

        this.start = appointment.start || new Date()
        this.end = appointment.end || new Date(this.start.getTime() + 60*60000)
        
        if(appointment.client)
            this.title = `${appointment.client.name} ${appointment.client.last_name_1}`
        else this.title = "";

        if(appointment.treatment)
            this.content= appointment.treatment.name;
        else this.content = "";

        if(appointment.worker)
            this.split =  appointment.worker.id
        else this.split = 0;

        //class: "blue-event",
        //if(appointment.end) {
            this.deletable = true
            this.resizable = true
            this.draggable = true
        //}
    }

}