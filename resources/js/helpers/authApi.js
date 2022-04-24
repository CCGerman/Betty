import axios from "axios";

const baseURL = 'http://localhost:8000/api'

const getHeaders = ( apiKey ) => {
    return {
        Accept: 'application/json',
        Authorization: apiKey
    }
}

export const getRequest = async ( url, apiKey ) => {

    return await fetch( baseURL + url , { headers: getHeaders(apiKey) })
        .then( res => res.json() )

}

export const postRequest = async ( url, apiKey, formData ) => {

    return await fetch( baseURL + url , {
        headers: getHeaders(apiKey),
        method: 'POST',
        body: formData
    }).then( res => res.json() )

}