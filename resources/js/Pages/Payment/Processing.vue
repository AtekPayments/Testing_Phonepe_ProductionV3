<template>
    <div class="h-screen grid grid-rows-1">
        <div class="mx-auto flex items-center">
            <div class="text-center p-10">
                <p class="text-gray-600 font-bold">Generating your ticket please wait ...</p>
                <Spinner/>
            </div>
        </div>
    </div>
</template>
<script>

import Spinner from "../../Shared/Components/Spinner";
import axios from "axios";

export default {

    name: "Processing",

    components: {Spinner},

    props: {
        order: String
    },

    async mounted() {
        console.log("Sending request ....")
       const res = await axios.get("/processing/init/" + this.order)
        const data = res.data
        if (data.status) this.onSuccess(data)
        else this.onFailure(data)
        console.log(data)
    },

    methods: {

        onSuccess: function (data) {

            const {product_id, op_type_id, order_id} = data

            if (op_type_id === 1)
            {
                if (product_id === 1 || product_id === 2) this.$inertia.get('/ticket/view/' + this.order)
                else if (product_id === 3) this.$inertia.get('/sv/dashboard')
                else this.$inertia.get('/tp/dashboard')
            }
            else if (op_type_id === 3)
            {
                if (product_id === 3) this.$inertia.get('/sv/dashboard')
                else this.$inertia.get('/tp/dashboard')
            }
            else
            {
                if (product_id === 1 || product_id === 2) this.$inertia.get('/ticket/view/' + order_id)
                else if (product_id === 3) this.$inertia.get('/sv/dashboard')
                else this.$inertia.get('/tp/dashboard')
            }

        },
        onFailure: function (data) {
            this.$swal.fire({
                icon: 'error',
                title: 'Payment Failed !',
                text: data.error,
                confirmButtonText: 'Try Again',
                showDenyButton: true,
                denyButtonText: 'Go Home !'
            }).then((res) => {
                if (res.isConfirmed) {
                    this.$inertia.get("/processing/" + this.order)
                } else if (res.isDenied) {
                    this.$inertia.get('/payment/failed/' + this.order)
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
