import { getRequest, postRequest } from '../../../helpers/authApi.js'

export const getProducts = async ( apiKey ) => {
    const result = await getRequest('/product', apiKey)
    return result
}

export const getProduct = async ( apiKey, productId ) => {
    const result = await getRequest('/product/'+productId, apiKey)
    return result
}

export const addProduct = async ( apiKey, product ) => {
    const formData = fillProduct( product )
    const result = await postRequest('/product', apiKey, formData)
    return result
}

export const saveProduct = async ( apiKey, product ) => {
    const formData = fillProduct( product )
    formData.append('_method', 'PUT')
    const result = await postRequest('/product/'+product.id, apiKey, formData)
    return result
}

export const deleteProduct = async ( apiKey, productId ) => {
    const formData = new FormData()
    formData.append('_method', 'DELETE')
    const result = await postRequest('/product/'+productId, apiKey, formData)
    return result
}

const fillProduct = ( product ) => {
    const formData = new FormData()
    formData.append('name', product.name)
    formData.append('price', product.price)
    formData.append('description', product.description)
    formData.append('stock', product.stock)
    return formData
}