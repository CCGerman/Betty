import { getRequest, postRequest } from '../../../helpers/authApi.js'

export const getInvoices = async ( apiKey ) => {
    const result = await getRequest('/invoice', apiKey)
    return result
}

export const getInvoice = async ( apiKey, invoiceId ) => {
    const result = await getRequest('/invoice/'+invoiceId, apiKey)
    return result
}

export const addInvoice = async ( apiKey, invoice ) => {
    const formData = fillInvoice( invoice )
    const result = await postRequest('/invoice', apiKey, formData)
    return result
}

export const saveInvoice = async ( apiKey, invoice ) => {
    const formData = fillInvoice( invoice )
    formData.append('_method', 'PUT')
    const result = await postRequest('/invoice/'+invoice.id, apiKey, formData)
    return result
}

export const deleteInvoice = async ( apiKey, invoiceId ) => {
    const formData = new FormData()
    formData.append('_method', 'DELETE')
    const result = await postRequest('/invoice/'+invoiceId, apiKey, formData)
    return result
}

const fillInvoice = ( invoice ) => {
    const formData = new FormData()
    /*
    formData.append('name', invoice.name)
    formData.append('last_name_1', invoice.last_name_1)
    formData.append('last_name_2', invoice.last_name_2)
    formData.append('phone', invoice.phone)
    formData.append('email', invoice.email)
    formData.append('address_1', invoice.address.address_1)
    formData.append('address_2', invoice.address.address_2)
    formData.append('city', invoice.address.city)
    formData.append('postalcode', invoice.address.postalcode)
    formData.append('country', invoice.address.country)
    formData.append('active', invoice.active)
    */
    return formData
}