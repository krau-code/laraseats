<template>
    <title>Reservations | LaraSeats Admin</title>

    <!-- Container -->
    <div class="bg-white px-6 py-4 drop-shadow-lg text-gray-800">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold">Manage reservations</h1>
            <router-link :to="{ name: 'reservations.pick' }" class="bg-blue-600 text-white px-3 py-2 hover:bg-blue-500">Add reservation</router-link>
        </div>

        <!-- Error Message -->
        <div v-if="error" class="w-full bg-red-100 border border-red-400 text-red-400 text-sm px-6 py-2 mt-2 mb-4">
            <p >{{ error }}</p>
        </div>

        <!-- Table -->
        <div v-if="reservations.length > 0" class="overflow-x-scroll">
            <table class=" text-sm text-left table-auto border-collapse border w-full">
                <thead>
                    <tr class="bg-white border-b-4 border-gray-200">
                        <th class="border px-2 py-2">No.</th>
                        <th class="border px-2 py-2">Name</th>
                        <th class="border px-2 py-2">Email</th>
                        <th class="border px-2 py-2">Date</th>
                        <th class="border px-2 py-2">Movie</th>
                        <th class="border px-2 py-2">Cinema</th>
                        <th class="border px-2 py-2">Amount</th>
                        <th class="border px-2 py-2">Quantity</th>
                        <th class="border px-2 py-2">Total Amount</th>
                        <th class="border px-2 py-2">Status</th>
                        <th class="border px-2 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(reservation, index) in reservations" :key="reservation.id" :class="{'bg-white': index % 2 === 1,'bg-gray-100': index % 2 === 0 }">
                        <td class="border px-2 py-2">{{ index + 1 }}</td>
                        <td class="border px-2 py-2 uppercase">{{ reservation.name }}</td>
                        <td class="border px-2 py-2">{{ reservation.email }}</td>
                        <!-- Schedule Date -->
                        <td v-if="reservation.date" class="border px-2 py-2 capitalize">
                            {{ reservation.date }}
                        </td>
                        <td v-else class="border px-2 py-2 lowercase text-xs">
                            <span class="text-red-700">reservered schedule doesn't exist anymore</span>
                        </td>
                        <!-- Movie Title -->
                        <td v-if="reservation.title" class="border px-2 py-2 capitalize">
                            {{ reservation.title }}
                        </td>
                        <td v-else class="border px-2 py-2 lowercase text-xs">
                            <span class="text-red-700">reservered movie doesn't exist anymore</span>
                        </td>
                        <!-- Cinema Name -->
                        <td class="border px-2 py-2 uppercase">
                            <span v-if="reservation.cinema_name">
                                {{ reservation.cinema_name }}
                            </span>
                            <span v-else class="text-red-700 text-xs lowercase">
                                reserved cinema doesn't exist anymore
                            </span>
                        </td>
                        <td class="border px-2 py-2">{{ getAmount(reservation.quantity, reservation.total_amount) }}</td>
                        <td class="border px-2 py-2">{{ reservation.quantity }}</td>
                        <td class="border px-2 py-2">{{ reservation.total_amount }}</td>
                        <td class="border px-2 py-2">
                            <span class="px-2 py-1 text-white text-xs rounded-full" :class="getStatus(reservation.date) == 'ended' ? 'bg-red-600' : 'bg-green-600'">{{ getStatus(reservation.date) }}</span>
                        </td>
                        <td class="border px-2 py-2">
                            <div class="flex gap-x-1">
                                <!-- Edit Button -->
                                <template v-if="getStatus(reservation.date) != 'ended' && reservation.cinema_name != null && reservation.title != null && reservation.date != null">
                                    <router-link :to="{ name: 'reservations.edit', params: { id: reservation.id } }" class="bg-blue-700 px-2 py-1 text-white hover:bg-blue-600">
                                        Edit
                                    </router-link>
                                </template>
                                <template v-else>
                                    <button class="bg-blue-500 px-2 py-1 text-white cursor-not-allowed" disabled>
                                        Edit
                                    </button>
                                </template>
                               
                                <!-- Delete Button -->
                                <button @click="deleteReservation(reservation.id, reservation.schedule_id, reservation.quantity)" class="bg-red-700 px-2 py-1 text-white hover:bg-red-600">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Loading -->
        <div v-else>
            <h1 class="text-center">No date available</h1>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            reservations: [],
            schedule: [],
            schedule_id: '',
            seat_left: '',
            new_seat_left: '',
            current_date: '',
            error: '',
            showMessage: false,
        }
    },
    methods: {
        getAmount(quantity, total_amount) {
            const amount = total_amount / quantity;

            return amount;
        },
        getStatus(date) {
            let date1 = new Date(date);
            let date2 = new Date(this.currentDate);

            if (date2 > date1) {
                return "ended";
            } else {
                return "active";
            }
        },
        async deleteReservation(id, schedule_id, quantity) {
            if (!window.confirm('Are you sure?')) {
                return
            }

            // Get single schedule for seat_left
            await axios.get('/admin/schedules/' + schedule_id)
            .then(response => {
                console.log(response.data);
                this.schedule = response.data[0];
            }).catch(error => {
                console.log('error');
                console.log(error.response.data);
                this.error = error.response.data;
            });

            // Delete reservation
            await axios.delete('/admin/reservations/' + id)
            .then(response => {
                console.log(response.data);

                // Check if schedule is existing
                if (this.schedule) {
                    this.seat_left = this.schedule.seat_left;
                    // Plus quantity plus seat_left
                    this.new_seat_left = quantity + this.seat_left;

                    // Make form data
                    const updateSeat = new FormData();
                    updateSeat.append('seat_left', this.new_seat_left);
                    updateSeat.append('_method', 'PUT');

                    // Update seat_left data in schedule table
                    axios.post('/admin/schedules/updateSeat/' + schedule_id, updateSeat)
                    .then(response => {
                        console.log(response.data);
                    }).catch(error => {
                        console.log(error);
                        console.log(error.response.data.message);
                        this.error = error.response.data.message;
                    });
                }
            }).catch(error => {
                console.log(error.response.data);
                this.error = error.response.data.message;
            });

            // Get reservations again
            await axios.get('/admin/reservations/data')
            .then(response => {
                console.log(response.data);
                this.reservations = response.data;
            }).catch(error => {
                console.log(error.response.data);
                this.error = error.response.data.message;
            });
            }
    },
    async mounted() {
        // Get all formatted schedules
        await axios.get('/admin/reservations/data')
        .then(response => {
            console.log(response.data);
            this.reservations = response.data;
        }).catch(error => {
            console.log(error.response.data);
            this.error = error.response.data.message;
        });
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
    }
}
</script>