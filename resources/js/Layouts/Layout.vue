<script setup>
import HeaderNav from '@/Layouts/SiteNavBar.vue'; // Adjust the path based on your structure
import SiteFooter from '@/Layouts/SiteFooter.vue'; // Adjust the path based on your structure

</script>


<template>
    <HeaderNav />
    <slot />
    <SiteFooter />
</template>
