<template>
    <title>Add cinema | LaraSeats Admin</title>

    <div class="w-full px-4 py-6 bg-white text-gray-900 drop-shadow md:w-3/4 md:px-8 md:py-8 lg:w-3/6 mx-auto">
        <!-- Heading -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold">Add a cinema</h1>
            <router-link :to="{ name: 'cinemas.index' }" class="text-gray-700 hover:text-gray-600">Go back</router-link>
        </div>

        <form @submit.prevent="createCinema">
            <input type="hidden" name="_token" :value="csrf" />

            <div class="flex flex-col md:flex-row gap-x-3">
                <!-- Cinema Name -->
                <div class="mb-4 grow">
                    <label for="title" class="text-gray-900">Cinema Name</label>
                    <div class="mt-2">
                        <input id="title" type="text" v-model="cinema_name" ref="focusThis" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2 capitalize" required/>
                    </div>
                </div>

                <!-- Seating Capacity -->
                <div class="mb-4 grow">
                    <label for="description" class="text-gray-900">Seating Capacity</label>
                    <div class="mt-2">
                        <input id="description" type="number" v-model="seating_capacity" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" required />
                    </div>
                    <p class="text-xs text-gray-500 mt-2">cannot be changed when created</p>
                </div>
            </div>

            <!-- Error Message -->
            <div v-if="error" class="w-full bg-red-100 border border-red-400 text-red-400 text-sm px-6 py-2 mt-2 mb-4">
                <p >{{ error }}</p>
            </div>

            <!-- Button -->
            <button class="w-full bg-gray-700 text-white px-6 py-2 mt-2">
                Add cinema
            </button>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            cinema_name: '',
            seating_capacity: '',
            error: '',
        }
    },
    methods: {
        async createCinema() {
            const data = new FormData();
            data.append('cinema_name', this.cinema_name);
            data.append('seating_capacity', this.seating_capacity);

            await axios.post('/admin/cinemas/create', data)
            .then(response => {
                console.log(response.data);
                this.$router.push({ name: 'cinemas.index' });
            }).catch(error => {
                console.log('1. ' + error);
                console.log('2. ' + error.response);
                console.log('3. ' + error.response.data);
                console.log('4. ' + error.response.data.message);
                this.error = error.response.data.message;
            });
        }
    },
    mounted() {
        this.$refs.focusThis.focus();
    }
}
</script>