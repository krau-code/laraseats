<template>
    <title>LaraSeats</title>

    <!-- Now showing -->
    <div>
        <h1 class="text-white font-bold text-3xl uppercase">Now Showing</h1>
        <div class="flex justify-around flex-wrap mt-2 md:justify-start md:gap-x-4">
            <div v-for="movie in movies" :key="movie.id" :class="getStatus(movie.showing_date, movie.end_date) == 'showing' ? '' : 'hidden'">
                <router-link :to="{ name: 'movie', params: { id: movie.id } }">
                    <div class="cursor-pointer p-2 hover:bg-slate-600">
                        <img :src="movie.poster ? `/storage/`+movie.poster : `/images/no-image.jpg`" :alt="movie.title" class="w-60 mx-auto rounded" />
                        <p class="text-center text-white capitalize mt-2">{{ movie.title }}</p>
                    </div>
                </router-link>
            </div>
        </div>
    </div>

    <!-- Coming soon -->
    <div class="mt-8">
        <h1 class="text-white font-bold text-3xl uppercase">Coming Soon</h1>
        <div class="flex justify-around flex-wrap mt-2 md:justify-start md:gap-x-4">
            <div v-for="movie in movies" :key="movie.id" :class="getStatus(movie.showing_date, movie.end_date) == 'coming' ? '' : 'hidden'">
                <router-link :to="{ name: 'movie', params: { id: movie.id } }">
                    <div class="cursor-pointer p-2 hover:bg-slate-600">
                        <img :src="movie.poster ? `/storage/`+movie.poster : `/images/no-image.jpg`" :alt="movie.title" class="w-60 mx-auto rounded" />
                        <p class="text-center text-white capitalize mt-2">{{ movie.title }}</p>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            movies: [],
            current_date: '',
        }
    },
    methods: {
        getStatus(showing_date,end_date) {
            let date1 = new Date(showing_date);
            let date2 = new Date(end_date);
            let date3 = new Date(this.currentDate);

            if (date3 >= date1 && date3 <= date2) {
                return "showing";
            } else if (date3 < date1) {
                return "coming";
            } else {
                return "ended"
            }
        },
    },
    async mounted() {
        await axios.get('/site/movies')
        .then(response => {
            console.log(response.data);
            this.movies = response.data;
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