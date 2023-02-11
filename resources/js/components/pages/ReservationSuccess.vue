<template>
    <title>Reserve Successful | LaraSeats</title>

    <div class="mx-auto mt-6 text-4xl leading-relaxed text-white md:w-3/5">
        <p>Hi, <span class="font-bold capitalize">{{ $route.params.name }}!</span></p>
        <p class="mt-2">You have successfully reserved <span class="font-bold">{{ $route.params.quantity }}</span> seat/s with a total amount of <span class="font-bold">&#8369;{{ $route.params.total_amount }}</span>.</p>
        <p class="mt-2">See you there!</p>

        <a href="/" class="text-xl text-gray-300 underline uppercase hover:text-gray-400">Go back to homepage</a>
    </div>
</template>

<script>
export default {

}
</script>