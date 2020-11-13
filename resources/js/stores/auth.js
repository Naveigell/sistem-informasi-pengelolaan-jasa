import axios from "axios";
import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export const store = new Vuex.Store({
    namespaced: true,
    state: {
        user: {
            data: null,
            check: false
        }
    },
    getters: {
        userdata: function (state) {
            return state.user.data;
        }
    },
    mutations: {
        async retrieveUserData(state){
            const axiosInstance = axios.create({
                baseURL: "http://localhost:8000/api/v1/",
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            await axiosInstance.get('/auth/session/data').then(function (response) {
                state.user.data = response.data.body;
            }).catch(function (){});

            state.user.check = true;
        },
    }
});
