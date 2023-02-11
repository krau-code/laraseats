<template>
    <title>Edit schedule | LaraSeats Admin</title>

    <div class="w-full px-4 py-6 bg-white text-gray-900 drop-shadow md:w-3/4 md:px-8 md:py-8 lg:w-3/6 mx-auto">
        <!-- Heading -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold">Edit a schedule</h1>
            <router-link :to="{ name: 'schedules.index' }" class="text-gray-700 hover:text-gray-600">Go back</router-link>
        </div>

        <form @submit.prevent="updateSchedule">
            <input type="hidden" name="_token" :value="csrf" />

            <!-- Movies -->
            <div class="mb-4 grow">
                <label class="text-gray-500">Movie</label>
                <div class="mt-2">
                    <select v-model="movie_id" class="w-full border border-gray-300 text-gray-500 focus:outline-none px-3 py-2 capitalize cursor-not-allowed bg-gray-100" disabled required>
                        <option :value="movie.id">
                            {{ movie.title }} 
                        </option>
                    </select>
                </div>
            </div>

            <!-- Cinemas -->
            <div class="mb-4 grow">
                <label class="text-gray-500">Cinema</label>
                <div class="mt-2">
                    <select v-model="cinema_id" class="w-full border border-gray-300 text-gray-500 focus:outline-none px-3 py-2 capitalize cursor-not-allowed bg-gray-100" disabled required>
                        <option :value="cinema.id">
                            {{ cinema.cinema_name }} 
                        </option>
                    </select>
                </div>
            </div>

            <p class="text-xs text-gray-400 italic mt-1 mb-4"> *Scheduled movie for chosen cinema cannot be changed. If you want to have a different movie and cinema, delete this schedule and add a new one.</p>

            <div class="flex flex-col md:flex-row gap-x-3">
                <!-- Date -->
                <div class="mb-4 grow">
                    <label for="date" class="text-gray-900">Date</label>
                    <div class="mt-2">
                        <input id="date" type="date" v-model="date" :min="new Date(movie.showing_date) < new Date(currentDate) ? currentDate : movie.showing_date" :max="movie.end_date" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" required/>
                    </div>
                </div>

                <!-- Amount -->
                <div class="mb-4 grow">
                    <label for="amount" class="text-gray-900">Amount</label>
                    <div class="mt-2">
                        <input  id="amount" type="number" step="any" v-model="amount" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" required/>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">decimal number is accepted</p>
                </div>
            </div>

            <!-- Error Message -->
            <div v-if="error" class="w-full bg-red-100 border border-red-400 text-red-400 text-sm px-6 py-2 mt-2 mb-4">
                <p >{{ error }}</p>
            </div>

            <!-- Button -->
            <button class="w-full bg-gray-700 text-white px-6 py-2 mt-2">
                Update schedule
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
            type: String,
        }
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            movie: [],
            cinema: [],
            schedules: [],
            schedule: [],
            movie_id: '',
            cinema_id: '',
            date: '',
            amount: 0,
            seat_left: '',
            current_date: '',
            showing_date: '',
            end_date: '',
            error: '',
        }
    },
    methods: {
        async updateSchedule() {
            // Get all schedules
            await axios.get('/admin/schedules/all')
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
                        if (value.id != this.id) {
                            return this.error = 'There is already a schedule for chosen cinema and date. Please choose a different cinema or date';
                        }
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

            // Make form data
            const data = new FormData();
            data.append('movie_id', this.movie_id);
            data.append('cinema_id', this.cinema_id);
            data.append('date', this.date);
            data.append('amount', this.amount);
            data.append('seat_left', this.seat_left);
            data.append('_method', 'PUT');

            // Post form data to schedule table
            await axios.post('/admin/schedules/' + this.id, data)
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
        // Get data for editing
        await axios.get('/admin/schedules/data/'+this.id+'/edit')
        .then(response => {
            this.schedule = response.data;
        }).catch(error => {
            console.log(error.response.data);
        });

        // Passing the data from database for editing
        this.movie_id = this.schedule.movie_id;
        this.cinema_id = this.schedule.cinema_id;
        this.date = this.schedule.date;
        this.amount = this.schedule.amount;
        this.seat_left = this.schedule.seat_left;

        // Get all movie
        await axios.get('/admin/movies/data/' + this.movie_id)
        .then(response => {
            console.log(response.data);
            this.movie = response.data;
        }).catch(error => {
            console.log(error.response.data);
            this.error = error.response.data;
        });

        // Get all cinema
        await axios.get('/admin/cinemas/' + this.cinema_id)
        .then(response => {
            console.log(response.data);
            this.cinema = response.data;
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