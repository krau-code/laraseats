<template>
    <title>Log in | LaraSeats Admin</title>
   
    <div class="w-full px-4 py-6 mx-4 bg-white text-gray-900 drop-shadow md:w-3/5 md:px-8 md:py-8 lg:w-2/6 2xl:w-3/12">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="text-3xl font-bold">Admin Staff</h1>
            <h2 class="text-xl">Log in</h2>
        </div>
        
        <!-- Error Message -->
        <div v-if="error" class="w-full bg-red-100 border border-red-400 text-red-400 text-sm px-6 py-2 mt-2 mb-4">
            {{ error }}
        </div>

        <!-- Login Form -->
        <form @submit.prevent="login">
            <input type="hidden" name="_token" :value="csrf" />
            
            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="text-gray-900">Email</label>
                <div class="mt-2">
                    <input id="email" type="email" v-model="email" ref="focusThis" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" required/>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <div class="flex justify-between">
                    <label for="password" class="text-gray-900">Password</label>

                    <!-- show password -->
                    <div class="flex gap-1 items-center">
                        <input type="checkbox" v-model="showPassword" name="show" id="show">
                        <label for="show" class="text-sm">Show Password</label>
                    </div>
                </div>
                <div class="mt-2">
                    <input id="password" :type="showPassword ? 'text' : 'password'" v-model="password" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" required/>
                </div>
            </div>

            <!-- Button -->
            <button type="submit" class="w-full bg-blue-700 text-white px-6 py-2 mt-2 mb-4">
                Log in
            </button>
        </form>
    </div>

    <!-- Link -->
    <p class="text-sm mt-4">Don't have an account? <router-link :to="{ name: 'admin.register' }" class="text-blue-700">Sign up</router-link></p>
    <a href="/" class="text-sm mt-2 text-blue-700">Go back to LaraSeats Site</a>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            showPassword: false,
            email: '',
            password: '',
            error: ''
        }
    },
    methods: {
        async login() {
            await console.log('Login clicked');

            await axios.post('/admin/authenticate', {
                email: this.email,
                password: this.password,
            }).then(response => {
                console.log(response.data);
                window.location.href = '/admin';
            }).catch(error => {
                console.log(error.response.data);
                this.error = error.response.data.error;
            });
        }
    },
    mounted () {
        this.$refs.focusThis.focus()
    }
}
</script>

<style>

</style>