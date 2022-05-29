export class Worker{

    constructor( workerObject ){
        this.id = workerObject.id,
        this.name = workerObject.name,
        this.last_name_1 = workerObject.last_name_1,
        this.last_name_2 = workerObject.last_name_2,
        this.email = workerObject.email,
        this.phone = workerObject.phone,
        this.active = workerObject.active || 1,
        this.address = (workerObject.address) ?
            this.address = new Address( workerObject.address) :
            new Address({})
    }
}

export class Address{

    constructor( addressObject ){
        this.address_1 = addressObject.address_1,
        this.address_2 = addressObject.address_2,
        this.city = addressObject.city,
        this.postalcode = addressObject.postalcode,
        this.country = addressObject.country
    }

}