<template>
    <div class="card shadow-sm border-0 h-100">
        <!-- <a :href="`blog/${blog.url}`"> -->
        <a :href="`video/${video.blog_id}-${video.url}`">
            <img :src="`assets/videos/${video.branch_name}/thumbnails/${video.image}`" class="card-img-top" :alt="`${video.branch_name}/${video.image}`"
                  style="height: 300px; width: 100%; object-fit: cover;">
        </a>
        <div class="card-body d-flex flex-column">
            <p class="card-title fw-bold lh-base">{{ video.subject}}</p>
            <p class="small">{{ video.subtitle}}</p>
            <div class="mt-auto">
                <div class="d-grid mt-2">
                    <!-- <a :href="`blog/${blog.url}`" class="btn btn-warning fw-bold"> -->
                    <a :href="`video/${video.blog_id}-${video.url}`" class="btn btn-danger text-white">
                        อ่านเพิ่มเติม <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
module.exports = {
    props:['video'],
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