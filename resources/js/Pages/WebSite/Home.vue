<script setup>
import { defineProps, computed, ref, watch } from 'vue';
import { usePage } from "@inertiajs/vue3";


// const props = defineProps({
//     table: Array,
// });


const page = usePage();

const locations = computed(() => page.props.locations);
const selectedState = ref("");
const selectedStateName = ref('');
const cities = ref([]);
const citiesDropdown = ref([]);



const selectedCity = ref("");
const selectedCityName = ref('');
// const citiesPlumber = ref([]);



const citiesPlumber = ref([]);
const currentPage = ref(1);
const lastPage = ref(null);
const loading = ref(false);

watch(selectedState, async (newState) => {
    if (newState) {
        try {
            // Find the selected state object
            const selectedLocation = locations.value.find(location => location.id == newState);

            if (selectedLocation) {
                selectedStateName.value = selectedLocation.name; // Store state name
            }

            // Fetch cities based on selected state
            const response = await fetch(`/ajax/get-cities/${newState}`);
            const data = await response.json();
            cities.value = data;
            citiesDropdown.value = data;

        } catch (error) {
            console.error('Error fetching cities:', error);
        }
    } else {
        cities.value = [];
        citiesDropdown.value = [];
        selectedStateName.value = ""; // Reset state name if none is selected
    }
});


// watch(selectedCity, async (newCity) => {
//     if (selectedState.value && newCity) { // Ensure both state and city are selected
//         try {
//             const response = await fetch(`/ajax/${selectedState.value}/${newCity}`);
//             const data = await response.json();
//             if (data.error) {
//                 console.error(data.error);
//                 citiesPlumber.value = []; // Reset list if there's an error
//             } else {
//                 citiesPlumber.value = data.citiesPlumber; // Correctly set the data
//             }
//         } catch (error) {
//             console.error('Error fetching companies:', error);
//             citiesPlumber.value = [];
//         }
//     } else {
//         citiesPlumber.value = []; // Reset if no city is selected
//     }
// });

watch(selectedCity, async (newCity) => {
    if (selectedState.value && newCity) {
        currentPage.value = 1; // Reset to first page
        await fetchPlumbers(newCity, 1);
    } else {
        citiesPlumber.value = [];
    }
});

async function fetchPlumbers(city, page) {
    if (loading.value) return; // Prevent duplicate requests
    loading.value = true;

    try {
        const response = await fetch(`/ajax/${selectedState.value}/${city}?page=${page}`);
        const data = await response.json();

        if (data.error) {
            console.error(data.error);
            citiesPlumber.value = [];
        } else {
            if (page === 1) {
                citiesPlumber.value = data.citiesPlumber.data; // Reset on new search
            } else {
                citiesPlumber.value.push(...data.citiesPlumber.data); // Append new results
            }
            lastPage.value = data.citiesPlumber.last_page;
        }
    } catch (error) {
        console.error('Error fetching companies:', error);
    } finally {
        loading.value = false;
    }
}


async function loadMore() {
    if (currentPage.value < lastPage.value) {
        currentPage.value++;
        await fetchPlumbers(selectedCity.value, currentPage.value);
    }
}

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
        <title>Home</title>
        <meta name="description" head-key="description" content="Home page description here">
        <meta name="keywords" head-key="keywords" content="home, example, keywords">
        <meta name="author" head-key="author" content="Your Website Name">
    </Head>


    <div class="slider">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/public/images/slider1.webp" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/public/images/slider1.webp" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/public/images/slider1.webp" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="search-bar">
        <div class="container">
            <div class="row justify-space-between align-items-center justify-content-center">
                <div class="col-md-12 p-0">
                    <form method="" action="#" class="top-form d-flex">
                        <!-- State Dropdown -->
                        <div class="col-md-4 p-0 form-group-icon">
                            <i class="las la-globe"></i>
                            <select name="state" id="state" class="form-control" v-model="selectedState">
                                <option value="">Select State</option>
                                <option v-for="location in locations" :key="location.id" :value="location.id">
                                    {{ location.name }}
                                </option>
                            </select>
                        </div>

                        <!-- City Dropdown -->
                        <div class="form-group col-md-4 p-0 form-group-icon">
                            <i class="las la-map-marker"></i>
                            <select name="city" id="city" class="form-control" v-model="selectedCity">
                                <option value="">Select City</option>
                                <option v-for="city in cities" :key="city.id" :value="city.city">
                                    {{ city.city }}
                                </option>
                            </select>
                        </div>



                        <!-- Search Button -->
                        <div class="form-group col-md-4 p-0">
                            <button type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <div class="categories">
        <div class="container">
            <div class="row">
                <div class="title">
                    <h3>Location</h3>
                    <a :href="route('state')">View All </a>
                </div>
            </div>

            <!-- <div class="row">
                <div class="col-md-2 mt-4" v-for="location in table" :key="location.id">
                    <div class="direct-box">
                        <div class="icon">
                            <i class="las la-map-marker-alt"></i>
                        </div>

                        <h3><a :href="route('states.city', location.slug)">{{ location.name }}</a></h3>
                    </div>
                </div>
            </div> -->

            <!-- Show this only when no city is selected -->
            <div class="row" v-if="!selectedCity">
                <div class="col-md-2 mt-4" v-for="citiesDropdown in cities" :key="citiesDropdown.id">
                    <div class="direct-box">
                        <div class="icon">
                            <i class="las la-map-marker-alt"></i>
                        </div>
                        <h3>
                            <a
                                :href="route('country.city', [slugify(selectedStateName), slugify(citiesDropdown.city)])">
                                {{ citiesDropdown.city }}
                            </a>
                        </h3>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mt-4" v-for="citiesPlumber in citiesPlumber" :key="citiesPlumber.id">
                    <div class="direct-box">
                        <div class="icon">
                            <i class="las la-tools"></i>
                        </div>
                        <h3>
                            <a :href="route('country.city.plumber', [slugify(selectedStateName), 'dede', citiesPlumber.company_slug])">{{
                                citiesPlumber.company_name }}</a>
                        </h3>
                        <p>{{ citiesPlumber.address }}</p>
                        <p><strong>Phone:</strong> {{ citiesPlumber.phone }}</p>
                    </div>
                </div>
            </div>

            <!-- Load More Button -->
            <button v-if="currentPage < lastPage" @click="loadMore" class="btn btn-primary">
                Load More
            </button>

        </div>
    </div>
</template>
