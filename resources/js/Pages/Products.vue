<template>
    <NavBar/>
    <Hero/>
    <div class="bg-white cursor-pointer rounded shadow hover:bg-gray-50 m-3 border" v-for="product in products" :key="product.id">
        <Link :href="product.url" class="appearance-none">
            <div class="grid grid-cols-6">
                <div class="grid grid-rows-2 border-r">
                    <div class="row-span-2 text-center">
                        <div class="grid content-center h-full">
                            <div class="flex justify-center">
                                <img :src="product.img" class="w-10 rounded-t-lg" alt="QR Ticket">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-rows-2 col-span-4 p-3">
                    <div class="text-xl text-gray-600 font-semibold">
                        {{ product.name }}
                    </div>
                    <div class="text-xs content-center h-full mt-2">
                        {{ product.description }}
                    </div>
                </div>
                <div class="grid grid-rows-2 border-blue-400 rounded-r">
                    <div class="row-span-2 text-center">
                        <div class="grid content-center h-full">
                            <div class="flex justify-center">
                                <i class="fa-solid fa-angle-right fa-2xl text-gray-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Link>
    </div>

</template>

<script>

import Hero from "../Shared/Hero";
import {Link} from '@inertiajs/inertia-vue3'
import NavBar from "../Shared/NavBar";
import Button from "../Shared/Component/Button";
import Footer from "../Shared/Footer";
import axios from "axios";
export default {

    props: {
        products: Array
    },

    name: "Products",

    components: {
        Footer,
        Button,
        NavBar,
        Hero,
        Link
    },

    data() {
        return {
            isLoading: false,
            isDisabled: false
        }
    },

    mounted() {
        this.orderStatus();
    },

    methods : {
        orderStatus : async function(){
            const res = await axios.get('/api/order/status');
            const data = res.data
            console.log(data);
        }
    }
}
</script>

<style scoped>

</style>
