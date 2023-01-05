<template>
    <title>Logging out</title>
</template>

<script>
import axios from "axios";

export default {
    async mounted(){
        await console.log('Logging out');
        await axios.post('/admin/logout')
        .then(response => {
            console.log(response.data);
            window.location.href = '/admin/login';
        }).catch(error => {
                    console.log(error.response.data);
        });
    }
}
</script>