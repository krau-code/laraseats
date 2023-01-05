<template>
    <title>Movie Schedule | LaraSeats</title>

    <h1 class="text-white text-2xl">Schedules for <span class="uppercase">{{ title }}</span></h1>

    <!-- Error Message -->
    <div v-if="error" class="w-full bg-red-100 border border-red-400 text-red-400 text-sm px-6 py-2 mt-2 mb-4">
        <p >{{ error }}</p>
    </div>

    <!-- Table -->
    <div v-if="schedules.length > 0" class="overflow-x-scroll mt-4">
        <table class=" text-sm text-left table-auto border-collapse border w-full">
            <thead>
                <tr class="text-white uppercase bg-slate-800 border-b-4 border-slate-700">
                    <th class="border px-2 py-2">Date</th>
                    <th class="border px-2 py-2">Cinema</th>
                    <th class="border px-2 py-2">Seats</th>
                    <th class="border px-2 py-2">Amount</th>
                    <th class="border px-2 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(schedule, index) in schedules" :key="schedule.id" :class="{
                    'bg-slate-600': index % 2 === 1,
                    'bg-slate-600': index % 2 === 0,
                    'hidden': schedule.movie_id != id || schedule.date < currentDate}" class="text-white"
                >
                    <td class="border px-2 py-2 capitalize">{{ schedule.date }}</td>
                    <!-- Cinema Name -->
                    <td v-if="schedule.cinema_name" class="border px-2 py-2 uppercase text-xs">{{ schedule.cinema_name }}</td>
                    <td v-else class="border px-2 py-2 lowercase text-xs">
                        <span class="text-red-300">scheduled cinema is not available</span>
                    </td>
                    <!-- Cinema Seat -->
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
                        <template v-if="schedule.seat_left > 0 && schedule.cinema_name != null">
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

    <!-- Loading -->
    <div v-else>
        <h1 class="text-center text-white mt-4">No schedule yet for this movie</h1>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: {
        id: {
            required: true,
            id: String
        },
        title: {
            required: true,
            id: String,
        },
    },
    data() {
        return {
            schedules: [],
            error: '',
            current_date: '',
        }
    },
    async mounted() {
        await axios.get('/site/schedules/byMovie/' + this.id)
        .then(response => {
            console.log(response.data);
            this.schedules = response.data;
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