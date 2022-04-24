export default {
    namespaced: true,
    state() {
        return {
            apiKey: '',
            logged: false
        }
    },
    mutations: {
        setKey( state, { key, logged } ){
            state.apiKey = key
            state.logged = logged
        }
    },
    actions: {
        async getApiKey( { commit } , { email, password } ) {
            const formData = new FormData()
            formData.append('email', email)
            formData.append('password', password)
            formData.append('device', 'vue-Device')

            const response = await fetch('http://localhost:8000/api/login',
            {
                body: formData,
                method: 'post',
                headers: {
                    Accept: 'application/json',
                },

            }).then(response => response.json())

            const { token } = response

            if(token){
                localStorage.setItem('apiKey', token)
                commit('setKey', {
                    key: 'Bearer '+token,
                    logged: true
                })
                return true
            } else return false
        },
        recoverKeyFromLocal( { commit } ){
            const key = localStorage.getItem('apiKey')
            if(key != ''){
                commit('setKey', {
                    key: 'Bearer '+key,
                    logged: true
                })
                return true
            } else return false
        },
        async logout( { state, commit } ){
            const response = await fetch('http://localhost:8000/api/logout',
            {
                method: 'post',
                headers: {
                    Accept: 'application/json',
                    Authorization: state.apiKey
                },

            })
            const { status } = response
            if(status === 200 || status === 401){
                localStorage.setItem('apiKey', '')
                commit('setKey', {
                    key: '',
                    logged: false
                })
                return true;
            } else return false;
        }
    }
}
