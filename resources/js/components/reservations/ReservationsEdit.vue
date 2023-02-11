<template>
    <title>Edit reservation | LaraSeats Admin</title>

    <div class="w-full px-4 py-6 bg-white text-gray-900 drop-shadow md:w-3/4 md:px-8 md:py-8 lg:w-3/6 mx-auto">
        <!-- Heading -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold">Edit a reservation</h1>
            <router-link :to="{ name: 'reservations.index' }" class="text-gray-700 hover:text-gray-600">Go back</router-link>
        </div>

        <form @submit.prevent="updateReservation">
            <input type="hidden" name="_token" :value="csrf" />

            <!-- Date -->
            <div class="mb-4 grow">
                <label class="text-gray-500">Scheduled date</label>
                <div class="mt-2">
                    <input id="showing_date" type="date" v-model="date" class="w-full border border-gray-300 text-gray-500 focus:outline-none px-3 py-2 cursor-not-allowed bg-gray-100" disabled required/>
                </div>
            </div>

            <!-- Title -->
            <div class="mb-4 grow">
                <label class="text-gray-500">Movie</label>
                <div class="mt-2">
                    <input id="showing_date" type="text" v-model="title" class="w-full border border-gray-300 text-gray-500 focus:outline-none px-3 py-2 cursor-not-allowed bg-gray-100 capitalize" disabled required/>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-x-3">
                <!-- Cinema -->
                <div class="mb-4 grow">
                    <label class="text-gray-500">Cinema</label>
                    <div class="mt-2">
                        <input type="text" v-model="cinema_name" class="w-full border border-gray-300 text-gray-500 focus:outline-none px-3 py-2 uppercase cursor-not-allowed bg-gray-100" disabled required/>
                    </div>
                </div>

                <!-- Amount -->
                <div class="mb-4 grow">
                    <label class="text-gray-500">Amount</label>
                    <div class="mt-2">
                        <input type="number" ref="amount" v-model="amount" class="w-full border border-gray-300 text-gray-500 focus:outline-none px-3 py-2 cursor-not-allowed bg-gray-100" disabled required/>
                    </div>
                </div>
            </div>

            <p class="text-xs text-gray-400 italic mt-1 mb-4"> *Reserved movie for chosen date cannot be changed. If you want to reserve a different movie and date, reserve a new one 
                <router-link :to="{ name: 'reservations.pick' }" class="text-blue-700">
                    here
                </router-link>.
            </p>

            <!-- Name -->
            <div class="mb-4 grow">
                <label for="name" class="text-gray-900">Name</label>
                <div class="mt-2">
                    <input id="name" type="text" ref="focusThis" v-model="name" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2 uppercase" required/>
                </div>
            </div>

            <!-- Email -->
            <div class="mb-4 grow">
                <label for="email" class="text-gray-900">Email</label>
                <div class="mt-2">
                    <input id="email" type="email" v-model="email" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" required/>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-x-3">
                <!-- Quantity -->
                <div class="mb-4 grow">
                    <label for="quantity" class="text-gray-500">Total reserved seats</label>
                    <div class="mt-2">
                        <input id="quantity" type="number" v-model="quantity" class="w-full border border-gray-300 text-gray-500 focus:outline-none px-3 py-2 cursor-not-allowed bg-gray-100" disabled required/>
                    </div>
                </div>

                <!-- Total Amount -->
                <div class="mb-4 grow">
                    <label for="amount" class="text-gray-500">Total amount</label>
                    <div class="mt-2">
                        <input  id="amount" ref="total" type="number" v-model="total_amount" class="w-full border border-gray-300 text-gray-500 focus:outline-none px-3 py-2 cursor-not-allowed bg-gray-100" disabled required/>
                    </div>
                </div>
            </div>

            <!-- Error Message -->
            <div v-if="error" class="w-full bg-red-100 border border-red-400 text-red-400 text-sm px-6 py-2 mt-2 mb-4">
                <p >{{ error }}</p>
            </div>

            <!-- Button -->
            <button class="w-full bg-gray-700 text-white px-6 py-2 mt-2">
                Update reservation
            </button>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: {
        id: {
            required: true,
            type: String
        }
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            reservation: [],
            schedule: [],
            date: '',
            title: '',
            cinema_name: '',
            amount: '',
            name: '',
            email: '',
            quantity: '',
            total_amount: '',
            error: '',
        }
    },
    methods: {
        async updateReservation() {
            // Make form data
            const data = new FormData();
            data.append('name', this.name);
            data.append('email', this.email);
            data.append('_method', 'PUT');

            // Post form data to reservation table
            await axios.post('/admin/reservations/' + this.id, data)
            .then(response => {
                console.log(response.data);
                this.$router.push({ name: 'reservations.index' });
            }).catch(error => {
                console.log(error);
                console.log(error.response.data.message);
                this.error = error.response.data.message;
            });
        }
    },
    async mounted() {
        this.$refs.focusThis.focus();

        // Get reservation for editing
        await axios.get('/admin/reservations/data/'+this.id + '/edit')
        .then(response => {
            console.log(response.data);
            this.reservation = response.data;
        }).catch(error => {
            console.log(error.response.data);
            this.error = error.response.data;
        });

        this.name = this.reservation.name;
        this.email = this.reservation.email;
        this.quantity = this.reservation.quantity;
        this.total_amount = this.reservation.total_amount;
        this.amount =  this.total_amount / this.quantity;
        
        // Get single schedule
        await axios.get('/admin/schedules/'+this.reservation.schedule_id)
        .then(response => {
            console.log(response.data);
            this.schedule = response.data[0];
        }).catch(error => {
            console.log(error.response.data);
            this.error = error.response.data;
        });

        this.date = this.schedule.date;
        this.title = this.schedule.title;
        this.cinema_name = this.schedule.cinema_name;
    
    },
}
</script>