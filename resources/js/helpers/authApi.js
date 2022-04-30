import axios from "axios";
import { Alert } from "bootstrap";

const baseURL = 'http://localhost:8000/api'

const getHeaders = ( apiKey ) => {
    return {
        Accept: 'application/json',
        Authorization: apiKey
    }
}

export const getRequest = async ( url, apiKey ) => {

    return await fetch( baseURL + url , { headers: getHeaders(apiKey) })
        .then( res => { 
            if(res.status != 200) throw new Error()
            else return res.json() })
        .catch( err => new Promise(() => {
            alert('Se perdió la conexión con el servidor')
            localStorage.setItem('apiKey', '')
            window.location.href = window.location.origin+'/login'
        } ))

}

export const postRequest = async ( url, apiKey, formData ) => {

    return await fetch( baseURL + url , {
        headers: getHeaders(apiKey),
        method: 'POST',
        body: formData
    }).then( res => { 
        if(res.status != 200) throw new Error()
        else res.json() })
    .catch( err => new Promise(() => {
        alert('Se perdió la conexión con el servidor')
        localStorage.setItem('apiKey', '')
        window.location.href = window.location.origin+'/login'
    } ))
}