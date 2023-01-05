<template>
    <title>Cinemas | LaraSeats Admin</title>

    <!-- Container -->
    <div class="bg-white px-6 py-4 drop-shadow-lg text-gray-900">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold text-gray-800">Manage cinemas</h1>
            <router-link :to="{ name: 'cinemas.create' }" class="bg-blue-600 text-white px-3 py-2 hover:bg-blue-500">Add cinema </router-link>
        </div>

        <!-- Error Message -->
        <div v-if="error" class="w-full bg-red-100 border border-red-400 text-red-400 text-sm px-6 py-2 mt-2 mb-4">
            <p >{{ error }}</p>
        </div>

        <!-- Table -->
        <div v-if="cinemas.length > 0" class="overflow-x-scroll">
            <table class=" text-sm text-left table-auto border-collapse border w-full">
                <thead>
                    <tr class="bg-white border-b-4 border-gray-200">
                        <th class="border px-2 py-2">No.</th>
                        <th class="border px-2 py-2">Cinema Name</th>
                        <th class="border px-2 py-2">Seating Capacity</th>
                        <th class="border px-2 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(cinema, index) in cinemas" :key="cinema.id" :class="{'bg-white': index % 2 === 1,'bg-gray-100': index % 2 === 0 }">
                        <td class="border px-2 py-2">{{ index + 1 }}</td>
                        <td class="border px-2 py-2 uppercase">{{ cinema.cinema_name }}</td> 
                        <td class="border px-2 py-2">{{ cinema.seating_capacity }}</td>
                        <td class="border px-2 py-2">
                            <div class="flex gap-x-1">
                                <router-link :to="{ name: 'cinemas.edit', params: { id: cinema.id } }" class="bg-blue-700 px-2 py-1 text-white hover:bg-blue-600">
                                Edit
                                </router-link>
                                <button @click="deleteCinema(cinema.id)" class="bg-red-700 px-2 py-1 text-white hover:bg-red-600">
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
            cinemas: [],
            error: '',
        }
    },
    methods: {
        async deleteCinema(id) {
            if (!window.confirm('Are you sure?')) {
                return
            }

            // Delete movie
           await axios.delete('/admin/cinemas/' + id)
            .then(response => {
                console.log(response.data);
            }).catch(error => {
                console.log(error.response.data);
                this.error = error.response.data.message;
            });

            // Get movies again
            await axios.get('/admin/cinemas')
            .then(response => {
                this.cinemas = response.data;
            }).catch(error => {
                console.log(error.response.data);
            });
        }
    },
    async mounted() {
        await axios.get('/admin/cinemas')
        .then(response => {
            this.cinemas = response.data;
            console.log(response.data);
        }).catch(error => {
            console.log(error.response.data);
            this.error = error.response.data.message;
        });
    },
}
</script>
