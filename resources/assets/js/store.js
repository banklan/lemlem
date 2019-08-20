import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import { totalmem } from 'os';

Vue.use(Vuex, axios);

const orders = JSON.parse(localStorage.getItem('orders')) || []
const charges = localStorage.getItem('charges') || null
const total = localStorage.getItem('order_cost') || null
const grandTotal = localStorage.getItem('total') || null

export const store = new Vuex.Store({
    state: {
        orders: orders,
        charges: charges,
        orderCost: total,
        user_loc: null,
        grandTotal: grandTotal
    },
    getters: {
        getOrders(state){
            localStorage.setItem('orders', JSON.stringify(state.orders))
            return state.orders;
        },
        getTotalCost(state){
            const val = state.orders.map(item=>item.cost).reduce((prev, next) => parseFloat(prev) + parseFloat(next), 0)
            state.orderCost = val
            localStorage.setItem('order_cost', val)
            return val
        },
        getCharges(state){
            if(state.orderCost < 500000){
                localStorage.setItem('charges', 50000)
                state.charges = 50000
                return 50000
            }
            if(state.orderCost > 500000 && state.orderCost < 1000000){
                
                state.charges = 70000
                localStorage.setItem('charges', 70000)
                return 70000
            }
            if(state.orderCost > 1000000 && state.orderCost < 2000000){
                
                state.charges = 100000
                localStorage.setItem('charges', 100000)
                return 100000
            }
            if(state.orderCost > 2000000){
                state.charges = 2000000
                localStorage.setItem('charges', 200000)
                return 200000
            }
        },
        getGrandTotalCost(state){
            const total = parseFloat(state.orderCost) + parseFloat(state.charges)
            state.grandTotal = total;
            localStorage.setItem('total', total)
            return total;
        }
    },
    actions:{
        
    },
    mutations: {
        add_order(state, payload){
            state.orders.push(payload)
        },
        update_order(state, payload){
            state.orders = payload
        },
        clear_order(state){
            state.orders = []
        },
        user_loc(state, payload){
            state.user_loc = payload
        }
    }
})
