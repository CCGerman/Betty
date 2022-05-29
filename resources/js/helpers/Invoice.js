export class Invoice{

    constructor( invoiceObject ){

        this.id = invoiceObject.id
        this.number = invoiceObject.number
        this.serie = invoiceObject.number
        this.client_id = invoiceObject.client_id
        this.date = invoiceObject.date
        this.total_amount = invoiceObject.total_amount
        this.balance = invoiceObject.balance
        this.deleted_on = invoiceObject.deleted_on
        this.note = invoiceObject.note

        this.lines = []
        for(const line of invoiceObject?.invoice_lines ?? []){
            console.log(invoiceObject.line)
            //this.lines.push(new InvoiceLine(line))
        }

        this.payments = []
        for(const payment of invoiceObject.payments ?? []){
            console.log(payment)
            //this.payments.push(new InvoicePayment(payment))
        }

        //this.header = new InvoiceHeader(invoiceObject.invoice_header)
        console.log(this.header)

    }

}