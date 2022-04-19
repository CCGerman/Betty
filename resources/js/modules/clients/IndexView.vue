<template>
  <h3 class="py-5" @click="fillClients()">Clientes</h3>
</template>

<script>
export default {
    data(){
        return{
            clients: []
        }
    },
    methods: {
        fillClients(){
            const apiKey = this.$store.state.apiKey
            fetch('http://localhost:8000/api/client',
            {
                headers: {
                    Accept: 'application/json',
                    Authorization: apiKey
                }
            }).then( response => response.json() ).then( console.log )
            .catch( console.log )
        },
        async getApiKey(){
            const email = prompt('insert email')
            const password = prompt('insert password')
            await this.$store.dispatch('getApiKey', {
                email,
                password
            })
        },
        async recoverKey(){
            return this.$store.dispatch('recoverKeyFromLocal')
        }
    },
    async mounted(){
        const response = await this.recoverKey()
        console.log(response)
        if(!response){
        await this.getApiKey()
        console.log('newKey')
        }
        this.fillClients()
    }
}
</script>

<style>

</style>