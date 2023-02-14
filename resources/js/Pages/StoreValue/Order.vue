<template>

    <nav-bar />

    <hero />

    <div class="bg-white m-2 p-3 shadow border text-center">
        <p class="font-bold text-lg text-gray-600">BUY NEW STORE VALUE PASS</p>
    </div>

    <form @submit.prevent="pass.post('create')">

        <div class="bg-white m-2 p-5 shadow border rounded">

            <div class="mb-3">
                <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Enter Amount</label>
                <input type="number" id="price" class="form_number_input" placeholder="₹ 500" required v-model="pass.price" v-on:keyup="validate"/>
                <div class="block m-1 text-sm text-red-500" v-if="pass.errors.price">
                    {{ pass.errors.price }}
                </div>
            </div>

            <div class="mt-3 grid grid-cols-3 gap-5">
                <chip :title = "'₹ 100'" v-on:click="addAmount(100)"/>
                <chip :title = "'₹ 200'" v-on:click="addAmount(200)"/>
                <chip :title = "'₹ 500'" v-on:click="addAmount(500)"/>
            </div>

        </div>

        <Button :title="'PROCEED TO PAY ₹ ' + pass.price" />

    </form>

</template>

<script>

import {useForm} from '@inertiajs/inertia-vue3'
import NavBar from "../../Shared/NavBar";
import Hero from "../../Shared/Hero";
import Chip from "../../Shared/Chip";
import Button from "../../Shared/Components/Button";
import axios from "axios";

export default {

    name: "Order",
    components: {Button, Chip, Hero, NavBar},

    data() {
        return {
            pass: useForm({
                price: 0
            }),
        }
    },

    methods: {
        addAmount: function (amount) {
            this.pass.price += parseInt(amount)
        },
        validate: function () {

            if (this.pass.price < 100) {
                this.pass.errors.price = 'Amount must be grater then 100'
            } else if (this.pass.price % 100 !== 0) {
                this.pass.errors.price = 'Amount must be multiple of 100'
            } else if (this.pass.price > 3000) {
                this.pass.errors.price = 'Amount must not be grater then 3000'
            } else {
                this.pass.errors.price = ''
            }

        }
    },

    async mounted() {

        const res = await axios.get('/sv/canIssuePass')
        const data = await res.data

        if (!data.status) {

            this.$swal.fire({
                icon: 'error',
                title: data.error,
                text: 'Please contact Mumbai Metro One for assistance !',
                confirmButtonText: 'Okay',
            }).then((res) => {
                if (res.isConfirmed) {
                    this.$inertia.get("/products")
                }
            })
        }
    }

}
</script>

<style scoped>

</style>
