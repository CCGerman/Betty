import { Billable } from './Billable.js'

export class Treatment extends Billable{

    constructor( treatment ){
        super( treatment )
        this.id = treatment.id
        this.duration = treatment.duration
    }

}