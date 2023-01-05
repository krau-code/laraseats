<template>
    <title>Create account | LaraSeats Admin</title>

    <div class="w-full px-4 py-6 mx-4 bg-white text-gray-900 drop-shadow md:w-3/5 md:px-8 md:py-8 lg:w-2/6 2xl:w-3/12">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="text-3xl font-bold">Admin Staff</h1>
            <h2 class="text-xl">Create account</h2>
        </div>

        <!-- Error Message -->
        <div v-if="error" class="w-full bg-red-100 border border-red-400 text-red-400 text-sm px-6 py-2 mt-2 mb-4">
            <p >{{ error }}</p>
        </div>
        
        <!-- Login Form -->
        <form @submit.prevent="createAccount">
            <input type="hidden" name="_token" :value="csrf" />
            
            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="text-gray-900">Name</label>
                <div class="mt-2">
                    <input id="name" type="text" v-model="name" ref="focusThis" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" required/>
                </div>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="text-gray-900">Email</label>
                <div class="mt-2">
                    <input id="email" type="email" v-model="email" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" required/>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <div class="flex justify-between">
                    <label for="password" class="text-gray-900">Password</label>

                    <!-- show password -->
                    <div class="flex gap-1">
                        <input type="checkbox" v-model="showPassword" id="showPassword">
                        <label for="showPassword">Show Password</label>
                    </div>
                </div>
                <div class="mt-2">
                    <input id="password" :type="showPassword ? 'text' : 'password'" v-model="password" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" required/>
                </div>
                <p v-if="moreThanSix()" :class="passwordError ? 'text-red-500' : 'text-gray-500'" class="text-xs mt-1">password must be atleast 6 characters</p>
                
                
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="text-gray-900">Confirm Password</label>
                <div class="mt-2">
                    <input id="password_confirmation" :type="showPassword ? 'text' : 'password'" v-model="password_confirmation" class="w-full border border-gray-300 text-gray-800 focus:outline-none px-3 py-2" required/>
                </div>
                <p v-if="passwordNotMatch()" :class="passwordError ? 'text-red-500' : 'text-gray-500'" class="text-xs mt-1">password does not match</p>
            </div>

            <!-- Button -->
            <button class="w-full bg-blue-700 text-white px-6 py-2 mt-2 mb-4">
                Create account
            </button>
        </form>
    </div>

    <!-- Link -->
    <p class="text-sm mt-4">Already have an account? <router-link :to="{ name: 'admin.login' }" class="text-blue-700">Sign in</router-link></p>
    <a href="/" class="text-sm mt-2 text-blue-700">Go back to LaraSeats Site</a>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            showPassword: false,
            passwordError: '',
            error: '',
        }
    },
    methods: {
        async createAccount() {
            await console.log('Create account clicked');

            if (this.password != this.password_confirmation || this.password.length < 6) {
                this.passwordError = 'passwordError';
            } else {
                await axios.post('/admin/create', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                }).then(response => {
                    console.log(response.data);
                    window.location.href = '/admin';
                }).catch(error => {
                    console.log(error.response.data);
                    this.error = error.response.data.message;
                });
            }
            
        },
        moreThanSix() {
            return this.password.length < 6;
        },
        passwordNotMatch() {
            if (this.password.length > 0 && this.password_confirmation.length > 0) {
                return this.password != this.password_confirmation
            } else {
                return false;
            }
        }
    },
    mounted() {
        this.$refs.focusThis.focus();
    }
}
</script>