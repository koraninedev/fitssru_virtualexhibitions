<template>
    <div class="card shadow-sm border-0 h-100">
        <!-- <a :href="`blog/${blog.url}`"> -->
        <a :href="`pic/${pic.blog_id}-${pic.url}`">
            <img :src="`assets/pictures/${pic.branch_name}/thumbnails/${pic.image}`" class="card-img-top" :alt="`${pic.branch_name}/${pic.image}`">
        </a>
        <div class="card-body d-flex flex-column">
            <p class="card-title fw-bold lh-base">{{ pic.subject}}</p>
            <p class="small">{{ pic.subtitle}}</p>
            <div class="mt-auto">
                <div class="d-grid mt-2">
                    <!-- <a :href="`blog/${blog.url}`" class="btn btn-warning fw-bold"> -->
                    <a :href="`pic/${pic.blog_id}-${pic.url}`" class="btn btn-danger text-white">
                        อ่านเพิ่มเติม <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
module.exports = {
    props:['pic'],
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