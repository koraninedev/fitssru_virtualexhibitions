<template>
    <div class="star-rating">
        <i class="far fa-star" v-for="i in 5" :key="i"></i>
        <!-- (จำนวนคะแนน / 5 ดาว) * 100 = x%  -->
        <div class="star-current" :style="{width: getRating(star.starCurrent) + '%'}">
            <i class="fas fa-star" v-for="i in 5" :key="i"></i>
        </div>
        <span class="text-muted"> 4.5 (50) </span>
    </div>
</template>
<script>
module.exports = {
    props:['star'],
    methods: {
        getRating (current) {
            return (current / 5) * 100
        }
    }
}
</script>

<style scoped>
</style>