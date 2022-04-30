import { Billable } from './Billable.js'

export class Treatment extends Billable{

    constructor( treatment ){
        super( treatment )
        this.productId = treatment.productId
        this.duration = treatment.duration
    }

}