import { Billable } from './Billable.js'

export class Product extends Billable{

    constructor( product ){
        super( product )
        this.id = product.id
        this.stock = product.stock
    }

}