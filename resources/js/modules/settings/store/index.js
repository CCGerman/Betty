import {
    getSettings,
    setSettings
} from '../helpers/SettingsDAO.js'

export default {
    namespaced: true,
    state() {
        return {
            settings: []
        }
    },
    mutations: {
        setStateSettings(state, settings) {
            state.settings = settings
        }
    },
    actions: {
        async getSettings({
            commit
        }, apiKey) {
            const {
                setting
            } = await getSettings(apiKey)
            commit('setStateSettings', setting)
        },
        async setSettings({ dispatch }, {
            apiKey,
            settings
        }) {
            await setSettings(apiKey, settings)
            dispatch('getSettings', apiKey)
        }
    },
    getters: {
        getProperty(state) {
            return (key) => {
                const entry = state.settings.find(e =>
                    e.key == key
                )
                if (entry) {
                    return entry.value
                }
            }
        },
    }
}
