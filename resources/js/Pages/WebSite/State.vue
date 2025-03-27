<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    table: Object, // Assuming pagination returns an object
});
</script>

<template>
    <Head>
        <title>State</title>
        <meta name="description" head-key="description" content="State page description here" />
        <meta name="keywords" head-key="keywords" content="State, example, keywords" />
        <meta name="author" head-key="author" content="Your Website Name" />
    </Head>

    <div class="breadcumb">
        <div class="container">
            <div class="row">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">State</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="categories">
        <div class="container">
            <div class="row">
                <div class="col-md-2 mt-4" v-for="location in table" :key="location.id">
                    <div class="direct-box">
                        <div class="icon">
                            <i class="las la-map-marker-alt"></i>
                        </div>
                        <h3>
                            <a :href="route('states.city', location.slug)">{{ location.name }}</a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
