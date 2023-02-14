<template>

    <nav-bar/>
    <hero/>

    <Transition name="bounce">
        <Recent
            v-if="recentOrders.length > 0"
            :recent-tickets="recentOrders"
        />
    </Transition>

    <Transition name="bounce">
        <Upcoming
            v-if="upcomingOrders.length > 0"
            :upcoming-tickets="upcomingOrders"
            class="mt-5"
        />
    </Transition>

    <Transition name="bounce">
        <empty v-if="upcomingOrders.length < 1" />
    </Transition>

    <AnchorButton
        :disabled="upcomingOrders.length > 1"
        :title="upcomingOrders.length > 1 ? 'Only two orders are allowed' : 'Book New Ticket'"
        :url="'/ticket/order'"
        :type="'button'"
    />

</template>

<script>

import NavBar from "../../Shared/NavBar";
import Recent from "../../Shared/Recent";
import Upcoming from "../../Shared/Upcoming";
import AnchorButton from "../../Shared/Components/AnchorButton";
import {Inertia} from "@inertiajs/inertia";
import axios from "axios";
import Hero from "../../Shared/Hero";
import Empty from "../../Shared/Empty";

export default {

    props: {
        user: Object,
        upcomingOrders: Array,
        recentOrders: Array
    },

    name: "Dashboard",

    components: {
        Empty,
        Hero,
        AnchorButton,
        Upcoming,
        Recent,
        NavBar
    },

    async mounted() {
        const res = await axios.get('/ticket/status');
        const data = res.data
        if (data.status) {
            Inertia.reload({only: ['upcomingOrders', 'recentOrders']})
        }
       if(this.upcomingOrders.length === 0 && this.recentOrders.length === 0){
           window.location.replace = "/ticket/order"
       }
    }
}
</script>

<style scoped>

</style>
