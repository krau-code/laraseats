<template>
    <title>Pick a schedule | LaraSeats Admin</title>

    <!-- Container -->
    <div class="bg-white px-6 py-4 drop-shadow-lg text-gray-900">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold uppercase">Pick a schedule</h1>
            <router-link :to="{ name: 'reservations.index' }" class="text-gray-700 hover:text-gray-600">Go back</router-link>
        
        </div>

        <!-- Error Message -->
        <div v-if="error" class="w-full bg-red-100 border border-red-400 text-red-400 text-sm px-6 py-2 mt-2 mb-4">
            <p >{{ error }}</p>
        </div>

        <!-- Table -->
        <div v-if="schedules.length > 0" class="overflow-x-scroll">
            <table class=" text-sm text-left table-auto border-collapse border w-full">
                <thead>
                    <tr class="bg-white border-b-4 border-gray-200">
                        <th class="border px-2 py-2">No.</th>
                        <th class="border px-2 py-2">Date</th>
                        <th class="border px-2 py-2">Movie</th>
                        <th class="border px-2 py-2">Poster</th>
                        <th class="border px-2 py-2">Duration</th>
                        <th class="border px-2 py-2">Cinema</th>
                        <th class="border px-2 py-2">Seats</th>
                        <th class="border px-2 py-2">Amount</th>
                        <th class="border px-2 py-2">Status</th>
                        <th class="border px-2 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="(schedule, index) in schedules" :key="schedule.id">
                        <template v-if="new Date(schedule.date) >= new Date(currentDate)">
                            <tr class="hover:bg-gray-100" :class="{'bg-white': index % 2 === 1,'bg-gray-100': index % 2 === 0 }">
                                <td class="border px-2 py-2">{{ index + 1 }}</td>
                                <td class="border px-2 py-2 capitalize">{{ schedule.date }}</td> 
                                <!-- Movie Title -->
                                <td v-if="schedule.title" class="border px-2 py-2 capitalize">
                                    {{ schedule.title }}
                                </td>
                                <td v-else class="border px-2 py-2 lowercase text-xs">
                                    <span class="text-red-700">reservered movie doesn't exist anymore</span>
                                </td>
                                <!-- Movie Poster -->
                                <td v-if="schedule.title" class="border px-2 py-2">
                                    <img :src="schedule.poster ? `/storage/`+schedule.poster : `/images/no-image.jpg`" :alt="schedule.title" class="w-12 mx-auto" />
                                </td>
                                <td v-else class="border px-2 py-2 lowercase text-xs">
                                    <span class="text-red-700">reservered movie doesn't exist anymore</span>
                                </td>
                                <!-- Movie Duration -->
                                <td v-if="schedule.title" class="border px-2 py-2">
                                    {{ schedule.hour + " " + getHour(schedule.hour) }}
                                {{ schedule.minute + " " + getMinute(schedule.minute) }}
                                </td>
                                <td v-else class="border px-2 py-2 lowercase text-xs">
                                    <span class="text-red-700">reservered movie doesn't exist anymore</span>
                                </td>
                                <!-- Cinema Name -->
                                <td v-if="schedule.cinema_name" class="border px-2 py-2 uppercase text-xs">{{ schedule.cinema_name }}</td>
                                <td v-else class="border px-2 py-2 lowercase text-xs">
                                    <span class="text-red-700">reserved cinema does not exist anymore</span>
                                </td>
                                <!-- Seats -->
                                <td class="border px-2 py-2">
                                    <template v-if="schedule.seat_left > 0">
                                        <span class="font-bold">{{ schedule.seat_left }}</span> available out of {{ schedule.seating_capacity }}
                                    </template>
                                    <template v-else>
                                        <span class="font-bold text-red-700 uppercase">ALL SEATS ARE RESERVED</span>
                                    </template>
                                </td>
                                <td class="border px-2 py-2">{{ schedule.amount }}</td>
                                <td class="border px-2 py-2">
                                    <span class="px-2 py-1 text-white text-xs rounded-full" :class="getStatus(schedule.date) == 'ended' ? 'bg-red-600' : 'bg-green-600'">{{ getStatus(schedule.date) }}</span>
                                </td>
                                <td class="border px-2 py-2">
                                    <template v-if="schedule.seat_left > 0 && schedule.cinema_id != null && schedule.title != null">
                                        <router-link :to="{ name: 'reservations.create', params: { id: schedule.id } }" class="bg-blue-700 px-2 py-1 text-white hover:bg-blue-600">
                                            Reserve
                                        </router-link>
                                    </template> 
                                    <template v-else>
                                        <button class="bg-blue-500 px-2 py-1 text-white cursor-not-allowed">
                                            Reserve
                                        </button>
                                    </template>
                                </td>
                            </tr>
                        </template>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- No data -->
        <div v-else>
            <h1 class="text-center">No data available</h1>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            schedules: [],
            current_date: '',
            error: '',
        }
    },
    methods: {
        getHour(hour) {
            if (hour > 1) {
                return "hrs";
            } else {
                return "hr";
            }
        },
        getMinute(minute) {
            if (minute > 1) {
                return "mins";
            } else {
                return "min";
            }
        },
        getStatus(date) {
            this.currentDate;

            if (this.current_date > date) {
                return "ended";
            } else {
                return "active";
            }
        },
        async createReservation() {
            // Get all schedules
            await axios.get('/admin/schedules')
            .then(response => {
                console.log(response.data);
                this.schedules = response.data;
            }).catch(error => {
                console.log(error.response.data);
                this.error = error.response.data;
            });

            // Loop through all schedules
            for (const key in this.schedules) {
                if (this.schedules.hasOwnProperty(key)) {
                    const value = this.schedules[key];

                    // check if there is the same date and cinema
                    if (value.date == this.date && value.cinema_id == this.cinema_id) {
                        return this.error = 'There is already a schedule for chosen cinema and date. Please choose a different cinema or date';
                    }
                }
            }

            // Get single cinema data
            await axios.get('/admin/cinemas/'+this.cinema_id)
            .then(response => {
                console.log(response.data);
                this.cinema = response.data;
            }).catch(error => {
                // console.log(error.response.data);
                this.error = error.response.data;
            });

            this.seat_left = this.cinema.seating_capacity;

            // Make form data
            const data = new FormData();
            data.append('movie_id', this.movie_id);
            data.append('cinema_id', this.cinema_id);
            data.append('date', this.date);
            data.append('amount', this.amount);
            data.append('seat_left', this.seat_left);

            // Post form data to schedule table
            await axios.post('/admin/schedules/create', data)
            .then(response => {
                console.log(response.data);
                this.$router.push({ name: 'schedules.index' });
            }).catch(error => {
                console.log('1. ' + error);
                console.log('2. ' + error.response);
                console.log('3. ' + error.response.data);
                console.log('4. ' + error.response.data.message);
                this.error = error.response.data.message;
            });
        }
    },
    async mounted() {
        // Get all schedules
        await axios.get('/admin/schedules/data')
        .then(response => {
            console.log(response.data);
            this.schedules = response.data;
        }).catch(error => {
            console.log(error.response.data);
            this.error = error.response.data;
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