<template>
    <title>Schedules | LaraSeats</title>

    <form>
        <input type="hidden" name="_token" :value="csrf" />

        <div class="flex flex-col">
            <label for="date" class="text-white text-xl">Choose a date</label>
            <input id="date" type="date" v-model="chosen_date" :min="currentDate" @change="getSchedule" class="w-full md:w-2/4 lg:w-2/6 border border-gray-300 text-slate-900 focus:outline-none px-3 py-2 mt-2   " />
        </div>
    </form>

    <!-- Error Message -->
    <div v-if="error" class="w-full bg-red-100 border border-red-400 text-red-400 text-sm px-6 py-2 mt-2 mb-4">
        <p >{{ error }}</p>
    </div>

    <div v-if="new Date(chosen_date) >= new Date(currentDate)">
        <!-- Table -->
        <div v-if="schedules.length > 0" class="overflow-x-scroll mt-8">
            <table class=" text-sm text-left table-auto border-collapse border w-full">
                <thead>
                    <tr class="text-white uppercase bg-slate-800 border-b-4 border-slate-700">
                        <th class="border px-2 py-2">Date</th>
                        <th class="border px-2 py-2">Movie</th>
                        <th class="border px-2 py-2">Cinema</th>
                        <th class="border px-2 py-2">Seats</th>
                        <th class="border px-2 py-2">Amount</th>
                        <th class="border px-2 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(schedule, index) in schedules" :key="schedule.id" :class="{
                        'bg-slate-600': index % 2 === 1,
                        'bg-slate-600': index % 2 === 0,}" class="text-white"
                    >
                    <!-- 'hidden': schedule.movie_id != id || schedule.date < currentDate -->
                        <td class="border px-2 py-2 capitalize">{{ schedule.date }}</td>
                        <!-- Movie Title -->
                        <td v-if="schedule.title" class="border px-2 py-2 capitalize">
                            <span>{{ schedule.title }}</span>
                        </td>
                        <td v-else class="border px-2 py-2 lowercase text-xs">
                            <span class="text-red-300">scheduled movie is not available</span>
                        </td>
                        <!-- Cinem Name -->
                        <td v-if="schedule.cinema_name" class="border px-2 py-2 uppercase text-xs">{{ schedule.cinema_name }}</td>
                        <td v-else class="border px-2 py-2 lowercase text-xs">
                            <span class="text-red-300">scheduled cinema is not available</span>
                        </td>
                        <!-- Cinema Seats -->
                        <td v-if="schedule.cinema_name" class="border px-2 py-2">
                            <template v-if="schedule.seat_left > 0">
                                <span class="font-bold">{{ schedule.seat_left }}</span> available out of {{ schedule.seating_capacity }}
                            </template>
                            <template v-else>
                                <span class="font-bold text-red-300 uppercase">ALL SEATS ARE RESERVED</span>
                            </template>
                        </td>
                        <td v-else class="border px-2 py-2 lowercase text-xs">
                            <span class="text-red-300">scheduled cinema is not available</span>
                        </td>
                        <td class="border px-2 py-2">{{ schedule.amount }}</td>
                        <td class="border px-2 py-2">
                            <template v-if="schedule.seat_left > 0 && schedule.cinema_name != null && schedule.title != null">
                                <router-link :to="{ name: 'schedule.reserve', params: { sched: schedule.id } }" class="bg-cyan-600 px-2 py-1 text-white hover:bg-cyan-500">
                                    Reserve
                                </router-link>
                            </template> 
                            <template v-else>
                                <button class="bg-cyan-700 px-2 py-1 text-white cursor-not-allowed">
                                    Reserve
                                </button>
                            </template>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else>
            <p class="text-center text-white mt-8">No schedule for chosen date</p>
        </div>
    </div>

    <div v-else-if="chosen_date">
        <p class="text-center text-white mt-8">Chosen day has already passed</p>
    </div>

    <div v-else>
        <p class="text-center text-white mt-8">No chosen date</p>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            schedules: [],
            chosen_date: '',
            current_date: this.currentDate,
            error: '',
        }
    },
    methods: {
        async getSchedule() {
            // Get all schedules
            await axios.get('/site/schedules/getByDate/' + this.chosen_date)
            .then(response => {
                this.schedules = response.data;
                console.log(response.data);
            }).catch(error => {
                console.log(error.response.data);
                this.error = error.response.data.message;
            });
        }
    },
    async mounted() {
        this.chosen_date = this.currentDate;

        // Get all schedules
        await axios.get('/site/schedules/getByDate/' + this.chosen_date)
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