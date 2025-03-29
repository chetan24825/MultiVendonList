<script setup>
import { defineProps } from 'vue';

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
                                    <b>Call Us</b>
                                    <p><a href="#"></a>{{ data.phone }}</p>
                                </div>
                            </li>
                            <li v-if="data.email">
                                <i class="las la-envelope"></i>
                                <div class="add-info">
                                    <b>Email Us</b>
                                    <p><a href="#">{{ data.email }}</a></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-form">
                        <form action="#" method="post">
                            <h3>Get in touch</h3>
                            <p>Lorem ipsum dolor, sit amet consectetur elit. </p>
                            <div class="form-group">
                                <input type="text" placeholder="Name">
                            </div>

                            <div class="form-group">
                                <input type="text" placeholder="Email">
                            </div>

                            <div class="form-group">
                                <input type="text" placeholder="Phone Number">
                            </div>

                            <div class="form-group">
                                <textarea placeholder="Your Message"></textarea>

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
