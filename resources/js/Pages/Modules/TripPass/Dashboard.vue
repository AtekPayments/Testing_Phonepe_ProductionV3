<template>
    <nav-bar />

    <Card
        :pass-details="pass"
        :user="user"
        :isSv="false"
        :balance="balance"
    />

    <div v-if="trip">
        <div class="text-center m-2 border bg-white rounded-lg">
            <div class="text-center p-2">
                <div class="flex justify-center m-1">
                    <QRCodeVue3
                        class="w-3/4"
                        :value="trip.qr_data"
                        :cornersSquareOptions="{ type: 'square' }"
                        :qr-options="{ typeNumber: 0, mode: 'Byte', errorCorrectionLevel: 'L' }"
                        :dots-options="{ type: 'square', color: '#1f1f1f' }"
                        :backgroundOptions="{ color: '#ffffff' }"
                    />
                </div>
                <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                    {{ trip.sl_qr_no }}
                </span>
            </div>
            <button v-on:click="getGraInfo(trip.sl_qr_no)" class="bg-blue-500 text-center p-2 rounded-b-lg text-gray-50 mt-2 w-full">
                <i class="fa-solid fa-circle-info mx-1"></i> NEED HELP
            </button>
        </div>
    </div>

    <GraModel
        v-if="trip"
        :slave_id="trip.sl_qr_no"
        :stations="stations"
    />

    <RefundModel
        :order_id="pass.sale_or_no"
        :refund="refund"
    />

    <PassButton
        v-if="!trip"
        :is-disabled="isLoadingGenTrip"
        :is-loading="isLoadingGenTrip"
        :type="'button'"
        :title="'GENERATE TRIP'"
        v-on:click="genTrip"
    />

    <!--<PassButton
        :is-disabled="isLoadingRefund"
        :is-loading="isLoadingRefund"
        :type="'button'"
        :title="'REFUND PASS'"
        v-on:click="refundPass"
    />-->

</template>

<script>

import QRCodeVue3 from "qrcode-vue3";
import axios from "axios";
import NavBar from "../../../Shared/NavBar";
import Card from "../../../Shared/Card";
import GraModel from "../../../Shared/Model/GraModel";
import RefundModel from "../../../Shared/Model/RefundModel";
import PassButton from "../../../Shared/Component/PassButton";

export default {

    props: {
        user: Object,
        pass: Object,
        trip: Object,
        stations: Array
    },

    data() {
        return {
            balance: 0,
            isLoadingGenTrip: false,
            isLoadingRefund: false,
            refund: {
                order_id: null,
                processing_fee: null,
                processing_fee_amount: null,
                refund_amount: null,
                pass_price: null,
            }
        }
    },

    name: "Dashboard",

    components: {PassButton, RefundModel, GraModel, Card, NavBar, QRCodeVue3},

    async mounted() {
        const res = await axios.get('/tp/status/' + this.pass.ms_qr_no);
        const data = res.data;
        this.balance = data.data.balanceTrip;
        this.$inertia.reload()
    },

    methods: {
        genTrip: async function() {
            this.isLoading = true
            this.$inertia.get('/tp/trip/' + this.pass.sale_or_no)
        },
        getGraInfo: function () {
            toggleModal('gra-help', true)
        },
        refundPass: async function () {
            this.isLoadingRefund = true
            const res = await axios.get('/refund/' + this.pass.sale_or_no)
            const data = await res.data
            if (data.status) {
                this.isLoadingRefund = false
                this.refund = data.refund
                toggleModal('refund-help', true)
            } else {
                this.isLoadingRefund = false
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.error,
                })
            }
        }
    }
}
</script>

<style scoped>

</style>
