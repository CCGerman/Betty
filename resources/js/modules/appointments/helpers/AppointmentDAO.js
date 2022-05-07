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
    
    const dateStart = appointment.start.toISOString().split('T')[0]
    const hourStart = appointment.start.toLocaleTimeString('it')
    const start = dateStart+'T'+hourStart

    const dateEnd = appointment.end.toISOString().split('T')[0]
    const hourEnd = appointment.end.toLocaleTimeString('it')
    const end = dateEnd+'T'+hourEnd

    const formData = new FormData()
    formData.append('time_start', start)
    formData.append('time_end', end)
    formData.append('worker_id', appointment.worker.id)
    formData.append('treatment_id', appointment.treatment.id)
    formData.append('client_id', appointment.client.id)
    return formData
}