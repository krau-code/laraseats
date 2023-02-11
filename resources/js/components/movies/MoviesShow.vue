<template>
    <title>Movie | LaraSeats</title>
    
    <div class="bg-white px-6 py-4 drop-shadow-lg text-gray-900">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold text-gray-800">Movie Details</h1>
            <router-link :to="{ name: 'movies.index' }" class="text-gray-700 hover:text-gray-600">Go back</router-link>
        </div>

        <hr>

        <div v-if="movie_id" class="md:mt-10">
            <div class="flex flex-col md:flex-row md:gap-x-6 md:justify-center">
                <!-- Image -->
                <h1 class="text-center text-4xl capitalize mb-4 md:hidden">{{ title }}</h1>
            <img :src="poster ? `/storage/`+poster : `/images/no-image.jpg`" :alt="title" class="w-full h-full rounded mx-auto md:w-80 md:h-full" />

                <!-- Info -->
                <div class="md:flex md:flex-col md:justify-start">
                    <!-- Title -->
                    <h1 class="hidden text-4xl capitalize mt-2 mb-4 md:mt-0 md:block md:text-6xl md:font-bold">{{ title }}</h1>

                    <!-- Rating & Genre -->
                    <div class="flex justify-center md:justify-start items-center mt-4 gap-x-2">
                        <span class="uppercase">{{ rating }}</span>
                        <div class="flex gap-x-2 text-white">
                            <span v-for="genre in genres" :key="genre" class="bg-slate-600 px-2 py-1 rounded-full">
                                {{ genre }}
                            </span>
                        </div>
                    </div>

                    <!-- Duration -->
                    <p class="text-center mt-2 uppercase md:mt-6 md:text-left">{{ hour }} hrs, {{ minute }} mins</p>
                    
                    <!-- Description -->
                    <p class="text-center mt-4 uppercase mb-4 md:text-left md:mt-8 md:mb-10">{{ description }}</p>
                </div>
            </div>
        </div>

        <div v-else class="text-center">
            No Data Available
        </div>
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
            movie_id: '',
            title: '',
            description: '',
            rating: '',
            genres: [],
            hour: '',
            minute: '',
            showing_date: '',
            end_date: '',
            poster: '',
            current_date: '',
        }
    },
    methods: {
        getStatus(showing_date,end_date) {
            this.currentDate;

            if (this.current_date >= showing_date && this.current_date <= end_date) {
                return "showing";
            } else if (this.current_date < showing_date) {
                return "coming";
            } else {
                return "ended"
            }
        },
    },
    async mounted() {
        await axios.get('/admin/movies/data/' + this.id)
        .then(response => {
            console.log(response.data);
            this.movie = response.data;
        }).catch(error => {
            console.log(error.response.data);
            this.error = error.response.data.message;
        });

        this.movie_id = this.movie.id;
        this.title = this.movie.title;
        this.description = this.movie.description;
        this.rating = this.movie.rating;
        this.genres = this.movie.genre.split(',');
        this.hour = this.movie.hour;
        this.minute = this.movie.minute;
        this.showing_adte = this.movie.showing_adte;
        this.end_date = this.movie.end_date;
        this.poster = this.movie.poster;
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
