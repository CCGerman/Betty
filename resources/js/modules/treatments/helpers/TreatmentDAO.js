import { getRequest, postRequest } from '../../../helpers/authApi.js'

export const getTreatments = async ( apiKey ) => {
    const result = await getRequest('/treatment', apiKey)
    return result
}

export const getTreatment= async ( apiKey, treatmentId ) => {
    const result = await getRequest('/treatment/'+treatmentId, apiKey)
    return result
}

export const addTreatment = async ( apiKey, treatment ) => {
    const formData = fillTreatment( treatment )
    const result = await postRequest('/treatment', apiKey, formData)
    return result
}

export const saveTreatment = async ( apiKey, treatment ) => {
    const formData = fillTreatment( treatment )
    formData.append('_method', 'PUT')
    const result = await postRequest('/treatment/'+treatment.id, apiKey, formData)
    return result
}

export const deleteTreatment = async ( apiKey, treatmentId ) => {
    const formData = new FormData()
    formData.append('_method', 'DELETE')
    const result = await postRequest('/treatment/'+treatmentId, apiKey, formData)
    return result
}

const fillTreatment = ( treatment ) => {
    const formData = new FormData()
    formData.append('name', treatment.name)
    formData.append('price', treatment.price)
    formData.append('description', treatment.description)
    formData.append('duration', treatment.duration)
    return formData
}