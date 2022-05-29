import { getRequest, postRequest } from '../../../helpers/authApi.js'

export const getSettings = async ( apiKey ) => {
    const result = await getRequest('/setting', apiKey)
    return result
}

export const setSettings = async ( apiKey, settings ) => {
    const formData = fillSettings( settings )
    const result = await postRequest('/setting', apiKey, formData)
    return result
}

export const deleteSettings = async ( apiKey, settings ) => {
    const formData = fillSettings( settings )
    formData.append('_method', 'DELETE')
    const result = await postRequest('/setting', apiKey, formData)
    return result
}

const fillSettings = ( settings ) => {
    const formData = new FormData()
    let i = 0
    for(const { key, value } of settings){
        formData.append('settings['+(++i)+'][key]', key)
        formData.append('settings['+i+'][value]', value)
    }
    return formData
}