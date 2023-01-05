<template>
    <title>Schedules | LaraSeats Admin</title>

    <!-- Container -->
    <div class="bg-white px-6 py-4 drop-shadow-lg text-gray-900">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold text-gray-800">Manage schedules</h1>
            <router-link :to="{ name: 'schedules.create' }" class="bg-blue-600 text-white px-3 py-2 hover:bg-blue-500">Add schedule </router-link>
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
                    <tr v-for="(schedule, index) in schedules" :key="schedule.id" :class="{'bg-white': index % 2 === 1,'bg-gray-100': index % 2 === 0 }">
                        <td class="border px-2 py-2">{{ index + 1 }}</td>
                        <td class="border px-2 py-2 capitalize">{{ schedule.date }}</td> 
                        <!-- Movie Title -->
                        <td v-if="schedule.movie_id" class="border px-2 py-2 capitalize">
                            <span>{{ schedule.title }}</span>
                        </td>
                        <td v-else class="border px-2 py-2 lowercase text-xs">
                            <span class="text-red-700">scheduled movie doesn't exist anymore</span>
                        </td>
                        <!-- Movie Poster -->
                        <td v-if="schedule.movie_id" class="border px-2 py-2">
                            <img :src="schedule.poster ? `/storage/`+schedule.poster : `/images/no-image.jpg`" :alt="schedule.title" class="w-12 mx-auto" />
                        </td>
                        <td v-else class="border px-2 py-2 lowercase text-xs">
                            <span class="text-red-700">scheduled movie doesn't exist anymore</span>
                        </td>
                        <!-- Movie Duration -->
                        <td v-if="schedule.movie_id" class="border px-2 py-2">
                            {{ schedule.hour + " " + getHour(schedule.hour) }}
                            {{ schedule.minute + " " + getMinute(schedule.minute) }}
                        </td>
                        <td v-else class="border px-2 py-2 lowercase text-xs">
                            <span class="text-red-700">scheduled movie doesn't exist anymore</span>
                        </td>
                        <!-- Cinema Name -->
                        <td v-if="schedule.cinema_id" class="border px-2 py-2 uppercase text-xs">{{ schedule.cinema_name }}</td>
                        <td v-else class="border px-2 py-2 lowercase text-xs">
                            <span class="text-red-700">scheduled cinema doesn't exist anymore</span>
                        </td>
                        <!-- Cinema Seating Capacity -->
                        <td v-if="schedule.cinema_id" class="border px-2 py-2">
                            <template v-if="schedule.seat_left > 0">
                                <span class="font-bold">{{ schedule.seat_left }}</span> available out of {{ schedule.seating_capacity }}
                            </template>
                            <template v-else>
                                <span class="font-bold text-red-700 uppercase">ALL SEATS ARE RESERVED</span>
                            </template>
                        </td>
                        <td v-else class="border px-2 py-2 lowercase text-xs">
                            <span class="text-red-700">scheduled cinema doesn't exist anymore</span>
                        </td>
                        <td class="border px-2 py-2">{{ schedule.amount }}</td>
                        <td class="border px-2 py-2">
                            <span class="px-2 py-1 text-white text-xs rounded-full" :class="getStatus(schedule.date) == 'ended' ? 'bg-red-600' : 'bg-green-600'">{{ getStatus(schedule.date) }}</span>
                        </td>
                        <td class="border px-2 py-2">
                            <div class="flex gap-x-1">
                                <!-- Edit Button -->
                                <template v-if="getStatus(schedule.date) != 'ended' && schedule.cinema_id != null && schedule.movie_id != null">
                                    <router-link :to="{ name: 'schedules.edit', params: { id: schedule.id } }" class="bg-blue-700 px-2 py-1 text-white hover:bg-blue-600">
                                        Edit
                                    </router-link>
                                </template>
                                <template v-else>
                                    <button class="bg-blue-500 px-2 py-1 text-white cursor-not-allowed" disabled>
                                        Edit
                                    </button>
                                </template>
                                
                                <!-- Delete Button -->
                                <button @click="deleteSchedule(schedule.id)" class="bg-red-700 px-2 py-1 text-white hover:bg-red-600">
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

            let date1 = new Date(date);
            let date2 = new Date(this.currentDate);

            if (date2 > date1) {
                return "ended";
            } else {
                return "active";
            }
            
            // console.log(date + ">>>" + this.currentDate);
        },
        async deleteSchedule(id) {
            if (!window.confirm('Are you sure?')) {
                return
            }

            // Delete movie
           await axios.delete('/admin/schedules/' + id)
            .then(response => {
                console.log(response.data);
            }).catch(error => {
                console.log(error.response.data);
                this.error = error.response.data.message;
            });

            // Get movies again
            await axios.get('/admin/schedules')
            .then(response => {
                this.schedules = response.data;
                console.log(response.data);
            }).catch(error => {
                console.log(error.response.data);
            });
        }
    },
    async mounted() {
        // Get all schedules
        await axios.get('/admin/schedules')
        .then(response => {
            this.schedules = response.data;
            console.log(response.data);
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