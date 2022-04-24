import { getRequest, postRequest } from '../../../helpers/authApi.js'

export const getClients = async ( apiKey ) => {
    const result = await getRequest('/client', apiKey)
    return result
}

export const getClient = async ( apiKey, clientId ) => {
    const result = await getRequest('/client/'+clientId, apiKey)
    return result
}

export const addClient = async ( apiKey, client ) => {
    const formData = fillClient( client )
    const result = await postRequest('/client', apiKey, formData)
    return result
}

export const saveClient = async ( apiKey, client ) => {
    const formData = fillClient( client )
    formData.append('_method', 'PUT')
    const result = await postRequest('/client/'+client.id, apiKey, formData)
    return result
}

export const deleteClient = async ( apiKey, clientId ) => {
    const formData = new FormData()
    formData.append('_method', 'DELETE')
    const result = await postRequest('/client/'+clientId, apiKey, formData)
    return result
}

const fillClient = ( client ) => {
    const formData = new FormData()
    formData.append('name', client.name)
    formData.append('last_name_1', client.last_name_1)
    formData.append('last_name_2', client.last_name_2)
    formData.append('phone', client.phone)
    formData.append('email', client.email)
    formData.append('address_1', client.address.address_1)
    formData.append('address_2', client.address.address_2)
    formData.append('city', client.address.city)
    formData.append('postalcode', client.address.postalcode)
    formData.append('country', client.address.country)
    formData.append('active', client.active)
    return formData
}