import axios from "axios";
import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export const store = new Vuex.Store({
    namespaced: true,
    state: {
        user: {
            data: null,
            check: false,
            picture: null
        }
    },
    getters: {
        userdata: function (state) {
            return state.user.data;
        }
    },
    mutations: {
        logout(state){
            state.user.data = state.user.picture = null;
            state.user.check = false;
        },
        async retrieveUserData(state){
            const axiosInstance = axios.create({
                baseURL: "http://localhost:8000/api/v1/",
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            // get user data
            await axiosInstance.get('/auth/session/data').then(function (response) {
                state.user.data = response.data.body;

                // get user profile image if session data check successful and picture is null
                if (state.user.picture == null) {
                    axiosInstance.get('/biodata/image').then((response) => {
                        state.user.picture = response.data.body.picture;
                    }).catch((error) => {
                        console.error(error)
                    });
                }
            }).catch(function (error){
                console.log(error)
            });

            state.user.check = true;
        },
    },
    actions: {
        reloadUserData(context) {
            context.state.user.picture = null;
            context.commit('retrieveUserData');
        }
    }
});
