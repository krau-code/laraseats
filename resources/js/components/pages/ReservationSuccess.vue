<template>
    <title>Reserve Successful | LaraSeats</title>

    <div class="mx-auto md:w-3/5 text-white text-4xl mt-6 leading-relaxed">
        <p>Hi, <span class="font-bold capitalize">{{ $route.params.name }}!</span></p>
        <p class="mt-2">You have successfully reserved <span class="font-bold">{{ $route.params.quantity }}</span> seat/s with a total amount of <span class="font-bold">&#8369;{{ $route.params.total_amount }}.00</span>.</p>
        <p class="mt-2">See you there!</p>

        <a href="/" class="hover:text-gray-400 text-xl uppercase text-gray-300 underline">Go back to homepage</a>
    </div>
</template>

<script>
export default {

}
</script>