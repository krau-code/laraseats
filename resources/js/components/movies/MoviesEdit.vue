<template>
    <title>Edit movie | LaraSeats Admin</title>

    <div class="w-full px-4 py-6 bg-white text-gray-900 drop-shadow md:w-3/4 md:px-8 md:py-8 lg:w-3/6 mx-auto">
        <!-- Heading -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold">Edit a movie</h1>
            <router-link :to="{ name: 'movies.index' }" class="text-gray-700 hover:text-gray-600">Go back</router-link>
        </div>

        <form @submit.prevent="updateMovie">
            <input type="hidden" name="_token" :value="csrf" />

            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="text-gray-900">Title</label>
                <div class="mt-2">
                    <input id="title" type="text" v-model="title" ref="focusThis" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" required/>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="text-gray-900">Description</label>
                <div class="mt-2">
                    <textarea id="description" type="text" v-model="description" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" rows="2" required>
                    </textarea>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-x-3">
                <!-- Rating -->
                <div class="mb-4 grow">
                    <label class="text-gray-900">Rating</label>
                    <div class="mt-2">
                        <select v-model="rating" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" required>
                            <option value="" selected disabled>Select a film rating</option>
                            <option value="G">G : General Audience</option>
                            <option value="PG">PG : Parental Guidance</option>
                            <option value="R13">R13 : Restricted-13</option>
                            <option value="SPG">SPG : Strong Parental Guidance</option>
                            <option value="R16">R16 : Restricted-16</option>
                            <option value="R18">R18 : Restricted-18</option>
                            <option value="X">X : Not for public exhibition</option>
                        </select>
                    </div>
                </div>

                <!-- Genre -->
                <div class="mb-4 grow">
                    <label for="genre" class="text-gray-900">Genre</label>
                    <div class="mt-2">
                        <input id="genre" type="text" v-model="tempGenre" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" @keydown="addGenre"/>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">press comma(,) to add genre</p>
                    <div class="flex flex-wrap gap-x-1">
                        <div v-for="genre in genres" :key="genre" @click="deleteGenre(genre)" class="text-xs bg-gray-300 text-gray-800 p-1 rounded-full mt-1 cursor-pointer">
                            {{ genre }}
                        </div>
                    </div>
                    <p v-if="genres.length > 0" class="text-xs text-gray-400 mt-1 italic">click the genre to remove it</p>
                </div>
            </div>

            <!-- Duration -->
            <div class="mb-4">
                <label for="duration" class="text-gray-900">Time Duration</label>
                <div class="flex gap-x-2">
                    <div class="grow">
                        <label for="hour" class="text-xs text-gray-600">Hour</label>
                        <input id="hour" type="number" v-model="hour" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" required/>
                    </div>
                    <div class="grow">
                        <label for="minute" class="text-xs text-gray-600">Minute</label>
                        <input id="minute" type="number" v-model="minute" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" required/>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-x-3">
                <!-- Showing Date -->
                <div class="mb-4 grow">
                    <label for="showing_date" class="text-gray-900">Showing Date</label>
                    <div class="mt-2">
                        <input id="showing_date" type="date" v-model="showing_date" :min="currentDate" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" required/>
                    </div>
                </div>

                <!-- End Date -->
                <div class="mb-4 grow">
                    <label for="end_date" class="text-gray-900">End Date</label>
                    <div class="mt-2">
                        <input :disabled="!showing_date ? true : false" id="end_date" type="date" v-model="end_date" :min="showing_date" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" required/>
                    </div>
                </div>
            </div>

            <!-- Poster -->
            <div class="mb-4">
                <label for="poster" class="text-gray-900">Poster</label>
                <div class="mt-2">
                    <input id="poster" type="file" ref="fileInput" @change="choosePoster" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2"/>
                </div>
                <img :src="movie.poster ? `/storage/`+movie.poster : `/images/no-image.jpg`" :alt="movie.title" class="w-32 mx-auto mt-3" />
            </div>

            
            <!-- Error Message -->
            <div v-if="error" class="w-full bg-red-100 border border-red-400 text-red-400 text-sm px-6 py-2 mt-2 mb-4">
                <p >{{ error }}</p>
            </div>

            <!-- Button -->
            <button class="w-full bg-gray-700 text-white px-6 py-2 mt-2">
                Update movie
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
            poster: '',
            title: '',
            description: '',
            rating: '',
            genres: [],
            hour: '',
            minute: '',
            showing_date: '',
            end_date: '',
            tempGenre: '',
            current_date: '',
            error: '',
        }
    },
    methods: {
        addGenre(e) {
            e.prevenDefault;

            if (e.key === "," && this.tempGenre) {
                if (!this.genres.includes(this.tempGenre)) {
                    this.genres.push(this.tempGenre);
                }
                this.tempGenre = '';
            }

            if (this.tempGenre == ",") {
                this.tempGenre = '';
            }
        },
        deleteGenre(genre) {
            this.genres = this.genres.filter((item) => {
                return genre !== item;
            });
        },
        choosePoster() {
            const file = this.$refs.fileInput.files[0];
            this.poster = file;
        },
        async updateMovie() {
            let genre = this.genres.join();

            const data = new FormData();
            data.append('title', this.title);
            data.append('description', this.description);
            data.append('rating', this.rating);
            data.append('genre', genre);
            data.append('hour', this.hour);
            data.append('minute', this.minute);
            data.append('showing_date', this.showing_date);
            data.append('end_date', this.end_date);
            data.append('poster', this.poster);
            data.append('_method', 'PUT');

            await axios.post('/admin/movies/' + this.id, data)
            .then(response => {
                console.log(response.data);
                this.$router.push({ name: 'movies.index' });
                console.log('success');
            }).catch(error => {
                console.log('1. ' + error);
                console.log('2. ' + JSON.stringify(error.response));
                console.log('3. ' + error.response.data);
                console.log('4. ' + error.response.data.message);
                this.error = error.response.data.message;
            });
        }
    },
    async created() {
        await axios.get('/admin/movies/'+this.id+'/edit')
        .then(response => {
            this.movie = response.data;
        }).catch(error => {
            console.log(error.response.data);
        });

        this.title = this.movie.title;
        this.description = this.movie.description;
        this.rating = this.movie.rating;
        this.genres = this.movie.genre.split(',');
        this.hour = this.movie.hour;
        this.minute = this.movie.minute;
        this.showing_date = this.movie.showing_date;
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

            return this.current_date
        }
    }
}
</script>