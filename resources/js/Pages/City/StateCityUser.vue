<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    citiesPlumber: Array,
    country: String,
    city: String,
    slug: String,
    zipcode: String,
    sortname: String,
});

// Function to generate slug for city names
const slugify = (text) => {
    return text
        .toLowerCase()
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/[^\w-]+/g, '') // Remove special characters
        .replace(/--+/g, '-') // Remove multiple hyphens
        .trim();
};


const getUpperCase = (text) => {
    return text
        .toLowerCase()
        .split(' ')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
};




</script>

<template>

    <Head>
        <title>{{ getUpperCase(city) }} - {{ sortname }}</title>
        <meta name="description" :content="`Find the best plumbers in ${getUpperCase(city)}, ${sortname}.`">
    </Head>

    <div class="breadcumb">
        <div class="container">
            <div class="row">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a :href="route('country.city', [country, slug])">{{ city }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="categories">
        <div class="container">
            <h2 class="text-center"> {{ getUpperCase(city) }}, {{ sortname }}</h2>

            <div class="row">
                <div class="col-md-4 mt-4" v-for="plumber in citiesPlumber" :key="plumber.id">
                    <div class="direct-box">
                        <div class="icon">
                            <i class="las la-tools"></i>
                        </div>
                        <h3>
                            <a :href="route('country.city.plumber', [country, city, plumber.company_slug])">
                                {{ plumber.company_name }}
                            </a>
                        </h3>
                        <p>{{ plumber.address }}</p>
                        <p><strong>Phone:</strong> {{ plumber.phone }}</p>
                    </div>
                </div>
            </div>

            <div v-if="citiesPlumber.length === 0" class="text-center mt-4">
                <p>No found in {{ city }}, {{ sortname }}.</p>
            </div>
        </div>
    </div>
</template>
