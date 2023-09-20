<template>
    <div class="card shadow-sm border-0 h-100">
        <!-- <a :href="`blog/${blog.url}`"> -->
        <a :href="`3d/${treed.blog_id}-${treed.url}`">
            <img :src="`assets/3dmodels/${treed.branch_name}/thumbnails/${treed.image}`" class="card-img-top" :alt="`${treed.branch_name}/${treed.image}`"
                style="height: 300px; width: 100%; object-fit: cover;">
        </a>
        <div class="card-body d-flex flex-column">
            <p class="card-title fw-bold lh-base">{{ treed.subject}}</p>
            <p class="small">{{ treed.subtitle}}</p>
            <div class="mt-auto">
                <div class="d-grid mt-2">
                    <a :href="`3d/${treed.blog_id}-${treed.url}`" class="btn btn-danger text-white">
                        อ่านเพิ่มเติม <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
module.exports = {
    props:['treed'],
    components: {
        'star-component': httpVueLoader('./star.vue')
    },
    methods: {
        getRating (current) {
            return (current / 5) * 100
        }
    }
}
</script>

<style scoped>
</style>