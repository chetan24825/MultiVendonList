<script setup>
import { defineProps, ref, computed } from 'vue';
import axios from 'axios';
const props = defineProps({
    country: Array,
    city: Array,
    data: Array,
});

const UrlFrame = (data) => {
    if (!data?.address) return "";
    const formattedAddress = data.address.replace(/,/g, "").replace(/\s+/g, "+");
    return `https://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=${formattedAddress}&z=14&output=embed`;
};




// Get Current URL
const currentUrl = window.location.href;

// Function to Extract Path Without First Segment
function extractPathWithoutFirstSegment(url, startIndex = 1) {
    const path = new URL(url, window.location.origin).pathname;
    const segments = path.split('/').filter(segment => segment !== ""); // Remove empty elements
    return segments.slice(startIndex).join('/');
}

// Reactive Form Data
const form = ref({
    name: '',
    email: '',
    phone: '',
    message: '',
    advertiser_id: computed(() => props.data?.id || ''),
    url: extractPathWithoutFirstSegment(currentUrl),
});

const successMessage = ref('');
// Get CSRF Token from Meta Tag
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// Handle Form Submission
const handleSubmit = async () => {
    try {
        const response = await axios.post('/lead/submit', form.value, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            }
        });

        alert(response.data.message);
        successMessage.value = response.data.message;
        // Reset Form while Keeping Reactivity
        form.value = {
            name: '',
            email: '',
            phone: '',
            message: '',
            advertiser_id: computed(() => props.data?.id || ''),
            url: extractPathWithoutFirstSegment(currentUrl),
        };

    } catch (error) {
        console.error("Form Submission Error:", error.response?.data || error.message);
        alert("Something went wrong. Please try again.");
    }
};



</script>
<template>
    <div class="shop-header">
    </div>


    <div class="shop-information">
        <div class="container">
            <div class="row">
                <div class="shop-details">
                    <div class="shop-logo">
                        <img src="/public/images/bussiness.png">
                    </div>
                    <div class="brand-name">
                        {{ data.company_name }}
                    </div>
                    <div class="shop-address">
                        <div class="shop-icon"></div>
                        <i class="las la-map-marker-alt"></i> Address : {{ data.address }}
                    </div>
                    <div class="shop-contact">
                        <ul>
                            <li v-if="data.phone">
                                <a href="#"><i class="las la-phone"></i><br> Call</a><br>
                                <p><a href="#">{{ data.phone }}</a></p>
                            </li>

                            <li v-if="data.email">
                                <a href="#"><i class="las la-envelope"></i><br> Email</a><br>
                                <p><a href="#">{{ data.email }}</a></p>
                            </li>

                            <li v-if="data.phone2">
                                <a href="#"><i class="lab la-whatsapp"></i><br> WhatsApp</a><br>
                                <p><a href="#">{{ data.phone2 }}</a></p>
                            </li>

                            <li v-if="data.website">
                                <a href="#"><i class="las la-globe"></i><br> Website</a><br>
                                <p><a href="#">{{ data.website }}</a></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="contact-us">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="contact-box">
                        <h3>Contact Information</h3>
                        <ul class="info-list clearfix">

                            <li v-if="data.address">
                                <i class="las la-phone"></i>
                                <div class="add-info">
                                    <b>Address</b>
                                    <p class="grey-txt">{{ data.address }}</p>
                                </div>
                            </li>

                            <li v-if="data.phone">
                                <i class="las la-phone"></i>
                                <div class="add-info">
                                    <b>Call Us </b>
                                    <p><a href="#"></a>{{ data.phone }}</p>
                                </div>
                            </li>
                            <li v-if="data.email">
                                <i class="las la-envelope"></i>
                                <div class="add-info">
                                    <b>Email Us</b>
                                    <p><a href="#">{{ data.email }} </a></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-form">
                        <form @submit.prevent="handleSubmit">
                            <h3>Get in touch</h3>
                            <p>Fill out the form to contact us.</p>
                            <p v-if="successMessage" class="alert alert-warning text-dark">{{ successMessage }}</p>
                            <div class="form-group">
                                <input v-model="form.name" type="text" placeholder="Name" required>
                                <!-- <input type="hidden" v-model="form.advertiser_id" value="{{ data.id }}"> -->
                            </div>
                            <div class="form-group">
                                <input v-model="form.email" type="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input v-model="form.phone" type="text" placeholder="Phone Number">
                            </div>
                            <div class="form-group">
                                <textarea v-model="form.message" placeholder="Your Message" required></textarea>
                            </div>
                            <button type="submit">Submit</button>
                        </form>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="map">
                        <iframe :src="UrlFrame(data)" width="100%" height="400" style="border:0;" allowfullscreen=""
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>


            </div>
        </div>
    </div>

</template>
