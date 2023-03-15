import Vue from 'vue';
import VueRouter from 'vue-router';

import NetworkConnectionsView from '../components/NetworkConnections.vue'
import SuggestionsView from '../components/NetworkConnections/SuggestionsView.vue'
import SentRequest from '../components/NetworkConnections/SentRequestView.vue'
import ReceivedRequests from '../components/NetworkConnections/ReceivedRequestView.vue'
import Connections from '../components/NetworkConnections/ConnectionsView.vue'

Vue.use(VueRouter);
const routes = [
    // {
    //     path: "/network-connections",
    //     name: "Network Connections",
    //     component: NetworkConnectionsView,
    // },
    {
        path: "/suggestions",
        name: "Suggestions",
        component: SuggestionsView,
    },
    {
        path: "/sent-requests",
        name: "Sent requests",
        component: SentRequest,
    },
    {
        path: "/received-requests",
        name: "Received requests",
        component: ReceivedRequests,
    },
    {
        path: "/connections",
        name: "Connections",
        component: Connections,
    },

];

// const router = createRouter({
//     history: createWebHistory(process.env.BASE_URL),
//     routes
// });

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router
