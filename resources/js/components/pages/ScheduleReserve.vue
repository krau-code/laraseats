<template>
    <title>Reserve Schedule | LaraSeats</title>

    <div class="w-full px-4 py-6 bg-slate-800 text-white drop-shadow md:w-3/4 md:px-8 md:py-8 lg:w-3/6 mx-auto">
        <!-- Heading -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold">Make a reservation</h1>
        </div>

        <form @submit.prevent="makeReservation">
            <input type="hidden" name="_token" :value="csrf" />

            <!-- Date -->
            <div class="mb-4 grow">
                <label class="text-white">Scheduled Date</label>
                <div class="mt-2">
                    <input id="showing_date" type="date" v-model="date" class="w-full border border-gray-300 text-white focus:outline-none px-3 py-2 cursor-not-allowed" disabled required/>
                </div>
            </div>

            <!-- Title -->
            <div class="mb-4 grow">
                <label class="text-white">Movie</label>
                <div class="mt-2">
                    <input id="showing_date" type="text" v-model="title" class="w-full border border-gray-300 text-white focus:outline-none px-3 py-2 capitalize cursor-not-allowed" disabled required/>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-x-3">
                <!-- Cinema -->
                <div class="mb-4 grow">
                    <label class="text-white">Cinema</label>
                    <div class="mt-2">
                        <input type="text" v-model="cinema_name" class="w-full border border-gray-300 text-white focus:outline-none px-3 py-2 uppercase cursor-not-allowed" disabled required/>
                    </div>
                </div>

                <!-- Amount -->
                <div class="mb-4 grow">
                    <label class="text-white">Amount</label>
                    <div class="mt-2">
                        <input type="number" ref="amount" v-model="amount" class="w-full border border-gray-300 text-white focus:outline-none px-3 py-2 cursor-not-allowed capitalize" disabled required/>
                    </div>
                </div>
            </div>

            <!-- Name -->
            <div class="mb-4 grow">
                <label for="name" class="text-white">Name</label>
                <div class="mt-2">
                    <input id="name" type="text" v-model="name" class="w-full border border-gray-300 text-slate-900 focus:outline-none px-3 py-2 uppercase" required/>
                </div>
            </div>

            <!-- Email -->
            <div class="mb-4 grow">
                <label for="email" class="text-white">Email</label>
                <div class="mt-2">
                    <input id="email" type="email" v-model="email" class="w-full border border-gray-300 text-slate-900 focus:outline-none px-3 py-2" required/>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-x-3">
                <!-- Quantity -->
                <div class="mb-4 grow">
                    <label for="quantity" class="text-white">How many seats?</label>
                    <div class="mt-2">
                        <input id="quantity" type="number" v-model="quantity" min="1" :max="seat_left >= 10 ? 10 : seat_left" class="w-full border border-gray-300 text-slate-900 focus:outline-none px-3 py-2" required/>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">{{ seat_left }} seats left</p>
                    <p v-if="quantity" class="text-xs text-gray-500 italic mt-1">*maximum of 10 seats per reservation</p>
                </div>

                <!-- Total Amount -->
                <div class="mb-4 grow">
                    <label for="amount" class="text-white">Total Amount</label>
                    <div class="mt-2">
                        <input  id="amount" ref="total" type="number" v-model="totalAmount" class="w-full border border-gray-300 text-white focus:outline-none px-3 py-2 cursor-not-allowed" disabled required/>
                    </div>
                </div>
            </div>

            <!-- Error Message -->
            <div v-if="error" class="w-full bg-red-100 border border-red-400 text-red-400 text-sm px-6 py-2 mt-2 mb-4">
                <p >{{ error }}</p>
            </div>

            <!-- Button -->
            <button class="w-full bg-slate-700 text-white px-6 py-2 mt-2 hover:bg-slate-600">
                Make reservation
            </button>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: {
        sched: {
            required: true,
            type: String
        }
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            date: '',
            title: '',
            quantity: '',
            cinema_name: '',
            amount: '',
            name: '',
            email: '',
            quantity: '',
            seat_left: '',
            total_amount: '',
            new_seat_left: '',
            current_date: '',
            error: '',
        }
    },
    methods: {
        async makeReservation() {
            // Make form data
            const data = new FormData();
            data.append('schedule_id', this.sched);
            data.append('name', this.name);
            data.append('email', this.email);
            data.append('quantity', this.quantity);
            data.append('total_amount', this.total_amount);

            // Post form data to reservation table
            await axios.post('/site/reservations/create', data)
            .then(response => {
                console.log(response.data);

                // Minus quantity to seat_left
                this.new_seat_left = this.seat_left - this.quantity;

                // Make form data
                const updateSeat = new FormData();
                updateSeat.append('seat_left', this.new_seat_left);
                updateSeat.append('_method', 'PUT');

                // Update seat_left data in schedule table
                axios.post('/site/schedules/updateSeat/' + this.sched, updateSeat)
                .then(res => {
                    console.log(res.data);
                    this.$router.push({ name: 'reserve.success',
                                        params: {
                                            name: this.name,
                                            quantity: this.quantity,
                                            total_amount: this.total_amount
                                        } });
                }).catch(err => {
                    console.log(err);
                    console.log(err.res.data.message);
                    this.error = err.res.data.message;
                });
            }).catch(error => {
                console.log(error.res.data.message);
                this.error = error.res.data.message;
            });
        }
    },
    async mounted() {
        // Get single schedule
        await axios.get('/site/schedules/'+this.sched)
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
        this.amount = this.schedule.amount;
        this.seat_left = this.schedule.seat_left;
    },
    computed: {
        currentDate() {
            // Getting current date
            const date = new Date();

            let day = date.getDate();
            let month = date.getMonth() + 1;
            let year = date.getFullYear();

            // This arrangement can be altered based on how we want the date's format to appear.
            this.current_date = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`; // "YYYY-MM-DD"

            return this.current_date;
        },
        totalAmount() {
            const total = this.quantity * this.amount;
            this.total_amount = total;

            return this.total_amount;
        }
    }
}
</script>