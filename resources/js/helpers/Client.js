export class Client{

    constructor( clientObject ){
        this.id = clientObject.id,
        this.name = clientObject.name,
        this.last_name_1 = clientObject.last_name_1,
        this.last_name_2 = clientObject.last_name_2,
        this.email = clientObject.email,
        this.phone = clientObject.phone,
        this.active = clientObject.active,
        this.address = (clientObject.address) ?
            this.address = new Address( clientObject.address) :
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