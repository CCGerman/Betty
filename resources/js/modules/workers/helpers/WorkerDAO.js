import { getRequest, postRequest } from '../../../helpers/authApi.js'

export const getWorkers = async ( apiKey ) => {
    const result = await getRequest('/worker', apiKey)
    return result
}

export const getWorker = async ( apiKey, workerId ) => {
    const result = await getRequest('/worker/'+workerId, apiKey)
    return result
}

export const addWorker = async ( apiKey, worker ) => {
    const formData = fillWorker( worker )
    const result = await postRequest('/worker', apiKey, formData)
    return result
}

export const saveWorker = async ( apiKey, worker ) => {
    const formData = fillWorker( worker )
    formData.append('_method', 'PUT')
    const result = await postRequest('/worker/'+worker.id, apiKey, formData)
    return result
}

export const deleteWorker = async ( apiKey, workerId ) => {
    const formData = new FormData()
    formData.append('_method', 'DELETE')
    const result = await postRequest('/worker/'+workerId, apiKey, formData)
    return result
}

const fillWorker = ( worker ) => {
    const formData = new FormData()
    formData.append('name', worker.name)
    formData.append('last_name_1', worker.last_name_1)
    formData.append('last_name_2', worker.last_name_2)
    formData.append('phone', worker.phone)
    formData.append('email', worker.email)
    formData.append('address_1', worker.address.address_1)
    formData.append('address_2', worker.address.address_2)
    formData.append('city', worker.address.city)
    formData.append('postalcode', worker.address.postalcode)
    formData.append('country', worker.address.country)
    formData.append('active', worker.active)
    return formData
}