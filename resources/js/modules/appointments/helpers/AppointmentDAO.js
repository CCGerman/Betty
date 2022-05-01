import { getRequest, postRequest } from '../../../helpers/authApi.js'

export const getAppointments = async ( apiKey ) => {
    const result = await getRequest('/appointment', apiKey)
    return result
}

export const getAppointment = async ( apiKey, appointmentId ) => {
    const result = await getRequest('/appointment/'+appointmentId, apiKey)
    return result
}

export const addAppointment = async ( apiKey, appointment ) => {
    const formData = fillAppointment( appointment )
    const result = await postRequest('/appointment', apiKey, formData)
    return result
}

export const saveAppointment = async ( apiKey, appointment ) => {
    const formData = fillAppointment( appointment )
    formData.append('_method', 'PUT')
    const result = await postRequest('/appointment/'+appointment.id, apiKey, formData)
    return result
}

export const deleteAppointment = async ( apiKey, appointmentId ) => {
    const formData = new FormData()
    formData.append('_method', 'DELETE')
    const result = await postRequest('/appointment/'+appointmentId, apiKey, formData)
    return result
}

const fillAppointment = ( appointment ) => {
    const formData = new FormData()
    formData.append('name', appointment.name)
    return formData
}