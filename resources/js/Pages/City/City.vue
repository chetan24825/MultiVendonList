<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    id: String,
    cities: Array,  // Correctly expecting an array of cities
    sortname: String
});

const slugify = (text) => {
    return text
        .toLowerCase()
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/[^\w-]+/g, '') // Remove special characters
        .replace(/--+/g, '-') // Remove multiple hyphens
        .trim();
};
</script>

<template>

    <Head>
        <title>{{ id }} Cities</title>
        <meta name="description" head-key="description" content="List of cities in {{ id }}">
        <meta name="keywords" head-key="keywords" content="Cities, {{ id }}, Locations">
        <meta name="author" head-key="author" content="Your Website Name">
    </Head>

    <div class="breadcumb">
        <div class="container">
            <div class="row">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="#">Cities in {{ id }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="categories">
        <div class="container">
            <div class="row">
                <div class="col-md-2 mt-4" v-for="city in cities" :key="city.id">
                    <div class="direct-box">
                        <div class="icon">
                            <i class="las la-map-marker-alt"></i>
                        </div>
                        <h3><a :href="route('country.city', [id, slugify(city.city)])">{{ city.city }}</a></h3>
                        <!-- Use city.city instead of location.name -->


                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
